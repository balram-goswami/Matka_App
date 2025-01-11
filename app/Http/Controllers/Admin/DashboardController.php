<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session, Redirect, DB, Validator;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService) {
        $this->dashboardService = $dashboardService;
    }
    public function index() {
        $view = 'Admin.Dashboard.Index';
        $userCount = $this->dashboardService->userCount();
        $enquiryCount = $this->dashboardService->enquiryCount();
        $subscribersCount = $this->dashboardService->subscribersCount();
        $postCounts = $this->dashboardService->postsCount();
        return view('Admin', compact('view','userCount','postCounts','subscribersCount','enquiryCount'));
    }

}
