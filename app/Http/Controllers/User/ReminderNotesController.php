<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use View;

use App\Models\UserReminderNotes;

class ReminderNotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function list()
    {
       	$viewData['pageTitle'] = "Reminder Notes";
        $records = UserReminderNotes::where('user_id',\Auth::user()->unique_id)->get();
        
        $viewData['records'] = $records;
        return view(roleFolder().'.reminder-notes.lists',$viewData);
    }

    public function addReminderNote(Request $request){  
        $viewData['pageTitle'] = "Add reminder note";
        $view = View::make(roleFolder().'.reminder-notes.add-reminder-notes',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function saveReminderNote(Request $request){
        $reminder_date = str_replace("/","-",$request->input("reminder_date"));
        $message = $request->input("message");

        $object = new UserReminderNotes();
        $object->reminder_date = date("Y-m-d",strtotime($reminder_date));
        $object->message = $message;
        $object->user_id = \Auth::user()->unique_id;
        $object->save();

        $response['status'] = true;
        $response['message'] = "Reminder saved successfully";
        return response()->json($response);
        
    }

    public function editReminderNote($id,Request $request){  
        $id = base64_decode($id);
        $record = UserReminderNotes::find($id);
        $viewData['pageTitle'] = "Edit reminder note";
        $viewData['record'] = $record;
        $view = View::make(roleFolder().'.reminder-notes.edit-reminder-notes',$viewData);
        $contents = $view->render();
        $response['contents'] = $contents;
        $response['status'] = true;
        return response()->json($response);
    }

    public function updateReminderNote($id,Request $request){
        $id = base64_decode($id);
        $reminder_date = str_replace("/","-",$request->input("reminder_date"));
        $message = $request->input("message");

        $object = UserReminderNotes::find($id);
        $object->reminder_date = date("Y-m-d",strtotime($reminder_date));
        $object->message = $message;
        $object->user_id = \Auth::user()->unique_id;
        $object->save();

        $response['status'] = true;
        $response['message'] = "Reminder saved successfully";
        return response()->json($response);
    }

    public function deleteRecord($id,Request $request){
        $id = base64_decode($id);
        UserReminderNotes::deleteRecord($id);
        $response['status'] = true;
        $response['message'] = "Reminder deleted successfully";
        return redirect()->back()->with("success","Record deleted successfully");
    }
}
