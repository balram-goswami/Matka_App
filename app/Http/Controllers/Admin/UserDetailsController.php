<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session, DataTables, Redirect, DB, Validator, Form;
use App\Services\{
    UserDetailsService
};

class UserDetailsController extends Controller
{
    protected $userDetailsService;
    public function __construct(UserDetailsService $userDetailsService)
    {
        $this->userDetailsService = $userDetailsService;
        
    }
    public function edit($id)
    {
        if (!$user = $this->userDetailsService->get($id)) {
            Session::flash('success', "User not found in our system.");
            return redirect()->route('users.index');
        }
        $view = 'Admin.Astrologer.AddEdit';
        return view('Admin', compact('view', 'user'));
    }

    public function update(Request $request, $id)
    {
        if (!$user = $this->userDetailsService->get($id)) {
            Session::flash('success', "User not found in our system.");
            return redirect()->route('users.index');
        }
        $this->userDetailsService->update($request, $user);
        Session::flash('success', "User Details update successfully.");
        return redirect()->route('users.index');
    }
}
