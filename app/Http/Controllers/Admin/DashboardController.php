<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Session, Redirect, DB, Validator;
use App\Services\DashboardService;
use App\Models\Wallet;

class DashboardController extends Controller
{
    protected $dashboardService;
    public function __construct(DashboardService $dashboardService) {
        $this->dashboardService = $dashboardService;
    }
    public function index() {
        $user = getCurrentUser();
        $balance = Wallet::where('user_id', $user->user_id)->get()->first();

        $view = 'Admin.Dashboard.Index';
        $userCount = $this->dashboardService->userCount();
        $postCounts = $this->dashboardService->postsCount();
        return view('Admin', compact('view','userCount','postCounts', 'balance'));
    }

}
