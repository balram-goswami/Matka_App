<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session, Redirect, DB, Validator;
use App\Services\DashboardService;

class AstrologerController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService) {
        $this->dashboardService = $dashboardService;
    }
    public function index()
    {
        $view = 'Admin.Astrologer.Index';
        return view('Admin', compact('view'));
    }

    public function profile()
    {
        $view = 'Admin.Astrologer.Profile';
        return view('Admin', compact('view'));
    }
}
