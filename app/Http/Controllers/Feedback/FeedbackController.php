<?php

namespace App\Http\Controllers\Feedback;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(){
        $view = 'views.Feedback';
        return view('Feedback', compact('view'));
    }
}
