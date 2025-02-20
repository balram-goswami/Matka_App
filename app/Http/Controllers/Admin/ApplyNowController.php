<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApplyNow;
use Session,Redirect;
use App\Services\CommunicationService;

class ApplyNowController extends Controller
{
    protected $communicationService;
    public function __construct(CommunicationService $communicationService) {
        $this->communicationService = $communicationService;
    }
    public function index()
    {
        $feedbacks = ApplyNow::orderBy('id', 'DESC')->paginate(pagination());
        $view = 'Admin.ApplyNow.Index';
        return view('Admin',compact('view','feedbacks'));
    }

    public function show($id)
    {
        $feedback = ApplyNow::find($id);
        $view = 'Admin.ApplyNow.Show';
        return view('Admin',compact('view','feedback'));
    }

    public function update(Request $request, $id)
    {
        $feedback = ApplyNow::find($id);
        $emailSubject = $request->input('subject');
        $content = $request->input('content');
        $emailBody = view('Email.ApplyNowReply', compact('feedback','content'));

        $this->communicationService->mail($feedback->email, $emailSubject, $emailBody, [], '', '', '', '');
        Session::flash ( 'success',"Reply Sent." );
        return Redirect::back();
    }
    
    public function destroy($id){
        $feedback = ApplyNow::find($id);
        $feedback->delete();
        Session::flash ( 'success',"Deleted." );
        return Redirect::back();
    }
}
