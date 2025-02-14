<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;

use App\Models\{
  Posts,
  Wallet,
  User,
  WalletTransactions,
  BidTransaction,
  GameResult
};

use Illuminate\Support\Facades\Http;
use Validator, DateTime, Config, Helpers, Hash, DB, Session, Auth, Redirect;

class HomeController extends Controller
{

  public function welcome()
  {
    $view = "Templates.Welcome";
    return view('Front', compact('view'));
  }
  
}
