<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubAdminController extends Controller
{
    public function subadminDashboard()
    {
        $view = 'Admin.SubAdmin.Index';
        return view('Admin', compact('view'));
    }

    public function subadminAddUsers()
    {
        $view = 'Admin.SubAdmin.AddPlayers';
        return view('Admin', compact('view'));
    }
}
