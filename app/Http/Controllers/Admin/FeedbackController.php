<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enquiry;
use Session,Redirect;
use App\Services\CommunicationService;

class FeedbackController extends Controller
{
    protected $communicationService;
    public function __construct(CommunicationService $communicationService) {
        $this->communicationService = $communicationService;
    }
    public function index(){
        $feedbacks = Enquiry::paginate(pagination());
        $view = 'Admin.Feedback.Index';
        return view('Admin',compact('view','feedbacks'));
    }
    public function show($id)
    {
        $feedback = Enquiry::find($id);
        $view = 'Admin.Feedback.Show';
        return view('Admin',compact('view','feedback'));
    }
    public function update(Request $request, $id)
    {
        $feedback = Enquiry::find($id);
        $emailSubject = $request->input('subject');
        $content = $request->input('content');
        $emailBody = view('Email.FeedbackReply', compact('feedback','content'));

        $this->communicationService->mail($feedback->email, $emailSubject, $emailBody, [], '', '', '', '');
        Session::flash ( 'success',"Reply Sent." );
        return Redirect::back();
    }
    public function destroy($id){
        $feedback = Enquiry::find($id);
        $feedback->delete();
        Session::flash ( 'success',"Feedback Deleted." );
        return Redirect::back();
    }
}
