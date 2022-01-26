<?php

namespace App\Http\Controllers\Associate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

use App\Models\Invoices;
use App\Models\CaseInvoices;
use App\Models\CaseInvoiceItems;
use App\Models\Cases;
use App\Models\ProfessionalDetails;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('associate');
    }

    public function caseInvoices($case_id)
    {
        $id = base64_decode($case_id);
        
        $subdomain = \Session::get("subdomain");
        $record = Cases::with(['AssingedMember','VisaService'])
                    ->where("id",$id)
                    ->first();
        $temp = $record;
        $temp->MainService = $record->Service($record->VisaService->service_id);
        $data = $temp;
        $case = $data;
        $viewData['subdomain'] = $subdomain;
        $viewData['record'] = $data;
        $viewData['case_id'] = $record->unique_id;
        $viewData['active_nav'] = "invoices";

        $viewData['case'] = $case;
        $viewData['pageTitle'] = "Case Invoices";
        $viewData['activeTab'] = "cases";
        return view(roleFolder().'.cases.invoices',$viewData);
    } 

    public function getCaseInvoice(Request $request)
    {
        $case_id = $request->input("case_id");
        $records = CaseInvoices::with(['Invoice'])
                        ->where("case_id",$case_id)
                        ->orderBy('id',"desc")
                        ->paginate();
        $viewData['records'] = $records;
        $view = View::make(roleFolder().'.cases.invoices-list',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['last_page'] = $records->lastPage();
        $response['current_page'] = $records->currentPage();
        $response['total_records'] = $records->total();
        return response()->json($response);
    }

    public function addCaseInvoice($case_id){

        $id = base64_decode($case_id);
        $case = Cases::find($id);
        $client = $case->Client($case->client_id);
        $professional = ProfessionalDetails::first();
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['pageTitle'] = "Add Invoice";
        $viewData['activeTab'] = "cases";
        return view(roleFolder().'.cases.add-invoice',$viewData);
    }


    public function saveCaseInvoice($id,Request $request){
        
        $validator = Validator::make($request->all(), [
            'invoice_date' => 'required',
            'due_date' => 'required',
            'bill_from' => 'required',
            'bill_to'=>'required',
            'items'=>'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $case_id = base64_decode($id);
        $case = Cases::find($case_id);
        
        $created_by = \Auth::user()->unique_id;
        
        $items = $request->input("items");
        
        $total_amount = 0;
        foreach($items as $item){
            $total_amount += $item['amount'];
        }
        $inv_unique_id = randomNumber();
        $invObject = new Invoices();
        $invObject->unique_id = $inv_unique_id;
        $invObject->client_id = $case->client_id;
        $invObject->amount = $total_amount;
        $invObject->payment_status = 'pending';
        $invObject->link_to = "case";
        $invObject->link_id = $case->unique_id;
        $invObject->bill_from = $request->input("bill_from");
        $invObject->bill_to = $request->input("bill_to");
        $invObject->invoice_date = $request->input("invoice_date");
        $invObject->due_date = $request->input("due_date");
        $invObject->created_by = $created_by;
        $invObject->save();

        $cinv_unique_id = randomNumber();
        $caseInvObj = new CaseInvoices();
        $caseInvObj->unique_id = $cinv_unique_id;
        $caseInvObj->case_id = $case->unique_id;
        $caseInvObj->invoice_id = $inv_unique_id;
        if($request->input("notes")){
            $caseInvObj->notes = $request->input("notes");
        }
        $caseInvObj->total_amount = $total_amount;
        $caseInvObj->save();

        foreach($items as $item){
            $itemObj = new CaseInvoiceItems();
            $itemObj->unique_id = randomNumber();
            $itemObj->case_id = $case->unique_id;
            $itemObj->case_invoice_id = $cinv_unique_id;
            $itemObj->particular = $item["particular_name"];
            $itemObj->amount = $item["amount"];
            $itemObj->save();
        }
        $subdomain = \Session::get('subdomain');
        $professional = ProfessionalDetails::first();
        $not_data['send_by'] = \Auth::user()->role;
        $not_data['added_by'] = \Auth::user()->unique_id;
        $not_data['user_id'] = $case->client_id;
        $not_data['type'] = "other";
        $not_data['notification_type'] = "invoice";
        $not_data['title'] = $professional->company_name." send you the invoice";
        $not_data['comment'] = "Invoice created for case id ".$case->unique_id;
        $not_data['url'] = "cases/".$subdomain."/invoices/view/".$cinv_unique_id;
        

        $other_data[] = array("key"=>"case_id","value"=>$case->unique_id);
        $other_data[] = array("key"=>"invoice_id","value"=>$inv_unique_id);
        $other_data[] = array("key"=>"case_invoice_id","value"=>$cinv_unique_id);
        
        $not_data['other_data'] = $other_data;
        
        sendNotification($not_data,"user");
        
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('cases/invoices/list/'.base64_encode($case->id));
        $response['message'] = "Invoice added sucessfully";
        
        return response()->json($response);
    }
 
    public function editCaseInvoice($invoice_id){

        $id = base64_decode($invoice_id);
        $invoice = CaseInvoices::with(["Invoice","InvoiceItems"])->where("id",$id)->first();
        $case_id = $invoice->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        $client = $case->Client($case->client_id);
        $professional = ProfessionalDetails::first();
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['record'] = $invoice;
        $viewData['pageTitle'] = "Edit Invoice";
        $viewData['activeTab'] = "cases";
        return view(roleFolder().'.cases.edit-invoice',$viewData);
    }


    public function updateCaseInvoice($invoice_id,Request $request){
        $validator = Validator::make($request->all(), [
            'invoice_date' => 'required',
            'due_date' => 'required',
            'bill_from' => 'required',
            'bill_to'=>'required',
            'items'=>'required',
        ]);

        if ($validator->fails()) {
            $response['status'] = false;
            $error = $validator->errors()->toArray();
            $errMsg = array();
            
            foreach($error as $key => $err){
                $errMsg[$key] = $err[0];
            }
            $response['message'] = $errMsg;
            return response()->json($response);
        }
        $invoice_id = base64_decode($invoice_id);
        $case_invoice = CaseInvoices::with(["Invoice","InvoiceItems"])->where("id",$invoice_id)->first();
        $case_id = $case_invoice->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        
        
        $items = $request->input("items");
        
        $total_amount = 0;
        foreach($items as $item){
            $total_amount += $item['amount'];
        }
        $inv_unique_id = $case_invoice->invoice_id;
        $invObject = Invoices::where("unique_id",$inv_unique_id)->first();
        $invObject->client_id = $case->client_id;
        $invObject->amount = $total_amount;
        $invObject->payment_status = 'pending';
        $invObject->link_to = "case";
        $invObject->link_id = $case->unique_id;
        $invObject->bill_from = $request->input("bill_from");
        $invObject->bill_to = $request->input("bill_to");
        $invObject->invoice_date = $request->input("invoice_date");
        $invObject->due_date = $request->input("due_date");
        $invObject->save();

        
        $caseInvObj = CaseInvoices::find($invoice_id);
        $cinv_unique_id = $caseInvObj->unique_id;
        if($request->input("notes")){
            $caseInvObj->notes = $request->input("notes");
        }
        $caseInvObj->total_amount = $total_amount;
        $caseInvObj->save();
        $inv_items = array();
        foreach($items as $item){
            if($item['id'] == 0){
                $item_unique_id = randomNumber(); 
                $itemObj = new CaseInvoiceItems();
                $itemObj->unique_id = $item_unique_id;
            }else{
                $itemObj = CaseInvoiceItems::where("unique_id",$item['id'])->first();
                $item_unique_id = $itemObj->unique_id;
            }
            $itemObj->case_id = $case->unique_id;
            $itemObj->case_invoice_id = $cinv_unique_id;
            $itemObj->particular = $item["particular_name"];
            $itemObj->amount = $item["amount"];
            $itemObj->save();
            $inv_items[] = $item_unique_id;
        }
        CaseInvoiceItems::where("case_invoice_id",$cinv_unique_id)->whereNotIn("unique_id",$inv_items)->delete();
        $response['status'] = true;
        $response['redirect_back'] = baseUrl('cases/invoices/list/'.base64_encode($case->id));
        $response['message'] = "Invoice edit sucessfully";
        
        return response()->json($response);
    }

    public function viewCaseInvoice($invoice_id){

        $id = base64_decode($invoice_id);
        $invoice = CaseInvoices::with(["Invoice","InvoiceItems"])->where("id",$id)->first();

        $case_id = $invoice->case_id;
        $case = Cases::where("unique_id",$case_id)->first();
        $client = $case->Client($case->client_id);
        $professional = ProfessionalDetails::first();
        $viewData['professional'] = $professional;
        $viewData['case'] = $case;
        $viewData['client'] = $client;
        $viewData['record'] = $invoice;
        $viewData['pageTitle'] = "View Invoice";
        return view(roleFolder().'.cases.view-invoice',$viewData);
    }

    public function deleteSingle($id){
        $id = base64_decode($id);
        Invoices::deleteRecord($id);
        return redirect()->back()->with("success","Record has been deleted!");
    }
    public function deleteMultiple(Request $request){
        $ids = explode(",",$request->input("ids"));
        for($i = 0;$i < count($ids);$i++){
            $id = base64_decode($ids[$i]);
            Invoices::deleteRecord($id);
        }
        $response['status'] = true;
        \Session::flash('success', 'Records deleted successfully'); 
        return response()->json($response);
    }

}
