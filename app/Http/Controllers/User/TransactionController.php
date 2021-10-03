<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;
use View;
use Razorpay\Api\Api;

use App\Models\Invoices;
use App\Models\CaseInvoiceItems;
use App\Models\CaseInvoices;
use App\Models\UserTransactions;
use App\Models\UserInvoices;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }
    
    public function payNow($subdomain,$invoice_id){
        $data['invoice_id'] = $invoice_id;
        $api_response = professionalCurl('cases/fetch-invoice',$subdomain,$data);

        if($api_response['status'] != 'success'){
            $response['status'] = "error";
            return redirect()->back()->with("error","Issue while finding invoice");
        }
        $data = $api_response['data'];
        $invoice = $data['invoice'];
        if($invoice['client_id'] != \Auth::user()->unique_id){
            return redirect(baseUrl('/'));
        }
        // pre($api_response);
        // exit;
        $viewData['pageTitle'] = "Pay Now";
        $viewData['invoice'] = $invoice;
        $viewData['invoice_id'] = $invoice_id;
        $viewData['pay_amount'] = $invoice['amount'];
        $viewData['subdomain'] = $subdomain;
        return view(roleFolder().'.pay-now',$viewData);   
    }
    public function validatePayNow(Request $request){
        if($request->input("payment_type") == 'credit_debit_card'){
            $validator = Validator::make($request->all(), [
                'card_holder_name' => 'required',
                'card_number' => 'required',
                'email' => 'required|email',
                'mobile_no' => 'required',
                'cvv' => 'required',
                'expire_date' => 'required',
            ]);
        }
        if($request->input("payment_type") == 'netbanking'){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'mobile_no' => 'required',
                'netbanking' => 'required',
            ]);
        }
        if($request->input("payment_type") == 'wallet'){
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'mobile_no' => 'required',
                'wallet' => 'required',
            ]);
        }
        if ($validator->fails()) {
            $response['status'] = false;
            $response['error_type'] = 'validation';
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $response['status'] = true;
        return response()->json($response);
    }
    public function submitPayNow(Request $request)
    {
        try {
            $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));
            $order_id = "order_".mt_rand(1,9999);
            $amount = $request->input("amount");
            $order  = $api->order->create([
              'receipt'         => $order_id,
              'amount'          => $amount, // amount in the smallest currency unit
              'currency'        => 'INR',// <a href="https://razorpay.freshdesk.com/support/solutions/articles/11000065530-what-currencies-does-razorpay-support" target="_blank">See the list of supported currencies</a>.)
              'payment_capture' =>  '0'
            ]);
            if(isset($order->id)){
                $response['status'] = true;
                $response['order_id'] = $order->id;
            }else{
                $response['status'] = false;
                $response['message'] = 'Order id not generated';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return response()->json($response);
    }

    public function paymentSuccess(Request $request){

        $invoice_id = $request->input("invoice_id");
        $razorpay_payment_id = $request->input("razorpay_payment_id");
        $subdomain = $request->input("subdomain");
        $razorpay_order_id = $request->input("razorpay_order_id");
        $razorpay_signature = $request->input("razorpay_signature");
        $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));
        $payment = $api->payment->fetch($razorpay_payment_id);
        try {
            $result = $api->payment->fetch($razorpay_payment_id)
                    ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();
            $data['payment_method'] = $payment->method;
            $data['amount_paid'] = $payment->amount / 100;
            $transaction_response = array("razorpay_order_id"=>$razorpay_order_id,"razorpay_payment_id"=>$razorpay_payment_id,"razorpay_signature"=>$razorpay_signature);
            $data['transaction_response'] = json_encode($result);
            $data['paid_by'] = \Auth::user()->unique_id;
            $data['payment_status'] = 'paid';
            $data['paid_date'] = date("Y-m-d H:i:s");
            $data['invoice_id'] = $invoice_id;
            $api_response = professionalCurl('cases/send-invoice-data',$subdomain,$data);

            $not_data['send_by'] = 'client';
            $not_data['added_by'] = \Auth::user()->unique_id;
            $not_data['type'] = "other";
            $not_data['title'] = "Payment paid by client ".\Auth::user()->first_name." ".\Auth::user()->last_name;
            $not_data['comment'] = "Payment paid for invoice ".$invoice_id;
            $other_data[] = array("key"=>"invoice_id","value"=>$invoice_id);
            $not_data['other_data'] = $other_data;
            $not_data['notification_type'] = "payment_received";
            sendNotification($not_data,"professional",$subdomain);
            
            $object = new UserTransactions();
            $object->user_id = \Auth::user()->unique_id;
            $object->professional = $subdomain;
            $object->invoice_id = $invoice_id;
            $object->payment_method = $payment->method;
            $object->save();

            if($api_response['status'] != 'success'){
                $response['status'] = false;
                $response['message'] = "Payment submission failed";
            }else{
                $response['status'] = true;
                $response['link_to'] = $api_response['link_to'];
                $response['message'] = $api_response['message'];
            }

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    public function paymentFailed(Request $request){

        $invoice_id = $request->input("invoice_id");
        $razorpay_payment_id = $request->input("razorpay_payment_id");
        $subdomain = $request->input("subdomain");
        $razorpay_order_id = $request->input("razorpay_order_id");
        $razorpay_signature = $request->input("razorpay_signature");
        $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));
        $payment = $api->payment->fetch($razorpay_payment_id);
        try {
            $result = $api->payment->fetch($razorpay_payment_id)
                    ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();
            $data['payment_method'] = $payment->method;
            $data['amount_paid'] = $payment->amount / 100;
            $transaction_response = array("razorpay_order_id"=>$razorpay_order_id,"razorpay_payment_id"=>$razorpay_payment_id,"razorpay_signature"=>$razorpay_signature);
            $data['transaction_response'] = json_encode($result);
            $data['paid_by'] = \Auth::user()->unique_id;
            $data['invoice_id'] = $invoice_id;
            $api_response = professionalCurl('cases/send-invoice-data',$subdomain,$data);

            $object = new UserTransactions();
            $object->user_id = \Auth::user()->unique_id;
            $object->professional = $subdomain;
            $object->invoice_id = $invoice_id;
            $object->payment_method = $payment->method;
            $object->save();

            if($api_response['status'] != 'success'){
                $response['status'] = false;
                $response['message'] = "Payment submission failed";
            }else{
                $response['status'] = true;
                $response['link_to'] = $api_response['link_to'];
                $response['message'] = $api_response['message'];
            }

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }


    public function assessmentPaymentSuccess(Request $request){

        try {
            $invoice_id = $request->input("invoice_id");
            $razorpay_payment_id = $request->input("razorpay_payment_id");
            $razorpay_order_id = $request->input("razorpay_order_id");
            $razorpay_signature = $request->input("razorpay_signature");
            $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));
            $payment = $api->payment->fetch($razorpay_payment_id);
            $result = $api->payment->fetch($razorpay_payment_id)
                    ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();
            $data['payment_method'] = $payment->method;
            $data['paid_amount'] = $payment->amount / 100;
            $transaction_response = array("razorpay_order_id"=>$razorpay_order_id,"razorpay_payment_id"=>$razorpay_payment_id,"razorpay_signature"=>$razorpay_signature);
            $data['transaction_response'] = json_encode($result);
            $data['paid_by'] = \Auth::user()->unique_id;
            $data['payment_status'] = "paid";
            $data['paid_date'] = date("Y-m-d H:i:s");
            UserInvoices::where("unique_id",$invoice_id)->update($data);
            // $api_response = professionalCurl('cases/send-invoice-data',$subdomain,$data);
            $response['status'] = true;
            $response['message'] = "Payment paid successfully";

            $mailData = array();
            $mail_message = "Hello Admin,<Br> ".\Auth::user()->first_name." ".\Auth::user()->last_name." has created the assessment. Please check the panel";
            
            $mailData['mail_message'] = $mail_message;
            $view = View::make('emails.notification',$mailData);
            
            $message = $view->render();
            $parameter['to'] = adminInfo('email');
            $parameter['to_name'] = adminInfo('name');
            $parameter['message'] = $message;
            
            $parameter['view'] = "emails.notification";
            $parameter['data'] = $mailData;
            $mailRes = sendMail($parameter);

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }

    public function assessmentPaymentFailed(Request $request){

        try {
            $invoice_id = $request->input("invoice_id");
            $razorpay_payment_id = $request->input("razorpay_payment_id");
            $subdomain = $request->input("subdomain");
            $razorpay_order_id = $request->input("razorpay_order_id");
            $razorpay_signature = $request->input("razorpay_signature");
            $api = new Api(config('razorpay.razor_key'), config('razorpay.razor_secret'));
            $payment = $api->payment->fetch($razorpay_payment_id);
            $result = $api->payment->fetch($razorpay_payment_id)
                    ->capture(array('amount'=>$payment['amount'])); 
            $result = $result->toArray();
            $data['payment_method'] = $payment->method;
            $data['amount_paid'] = $payment->amount / 100;
            $transaction_response = array("razorpay_order_id"=>$razorpay_order_id,"razorpay_payment_id"=>$razorpay_payment_id,"razorpay_signature"=>$razorpay_signature);
            $data['transaction_response'] = json_encode($result);
            $data['paid_by'] = \Auth::user()->unique_id;
            $data['invoice_id'] = $invoice_id;
            $api_response = professionalCurl('cases/send-invoice-data',$subdomain,$data);

            $object = new UserTransactions();
            $object->user_id = \Auth::user()->unique_id;
            $object->professional = $subdomain;
            $object->invoice_id = $invoice_id;
            $object->payment_method = $payment->method;
            $object->save();

            if($api_response['status'] != 'success'){
                $response['status'] = false;
                $response['message'] = "Payment submission failed";
            }else{
                $response['status'] = true;
                $response['link_to'] = $api_response['link_to'];
                $response['message'] = $api_response['message'];
            }

        } catch (\Exception $e) {
            $response['status'] = false;
            $response['message'] = $e->getMessage();
            
        }
        
       return response()->json($response);
    }
}
