<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscibers;
use Session,Redirect;
use App\Services\CommunicationService;

class SubscribersController extends Controller
{
    protected $communicationService;
    public function __construct(CommunicationService $communicationService) {
        $this->communicationService = $communicationService;
    }
    public function index(){
        $subscibers = Subscibers::paginate(pagination());
        $view = 'Admin.Subscribers.Index';
        return view('Admin',compact('view','subscibers'));
    }
    public function show($id)
    {
        $subsciber = Subscibers::find($id);
        $view = 'Admin.Subscribers.Show';
        return view('Admin',compact('view','subsciber'));
    }
    public function update(Request $request, $id)
    {
        $subsciber = Subscibers::find($id);
        $emailSubject = $request->input('subject');
        $content = $request->input('content');
        $emailBody = view('Email.SubscriberReply', compact('subsciber','content'));

        $this->communicationService->mail($subsciber->email, $emailSubject, $emailBody, [], '', '', '', '');
        Session::flash ( 'success',"Reply Sent." );
        return Redirect::back();
    }
    public function destroy($id){
        $subsciber = Subscibers::find($id);
        $subsciber->delete();
        Session::flash ( 'success',"Subscriber Deleted." );
        return Redirect::back();
    }
}
