<?php

namespace App\Http\Controllers\Player;

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

class PlayerController extends Controller
{

  public function playerDashboard()
  {
    $view = "Templates.Home";
    $user = getCurrentUser();
    if ($user && $user->status === 'Block') {
      $view = "Templates.Block";
      return view('Front', compact('view'));
    }

    // Fetch the user's wallet and theme options
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $homePage = getThemeOptions('homePage');
    $headerOption = getThemeOptions('header');
    $optionGame = getPostsByPostType('optiongame', 0, 'new', true);
    $sattaGame = getPostsByPostType('numberGame', 0, 'new', true);

    // Get the current time and today's date
    $now = \Carbon\Carbon::now('Asia/Kolkata');  // Ensure the correct timezone
    $today = \Carbon\Carbon::today('Asia/Kolkata');

    // Loop through each Satta game and calculate the open/close times
    foreach ($sattaGame as &$satta) {
      // Parse the morning and evening times for the game
      $morningStartTime = isset($satta['extraFields']['open_time_morning'])
        ? \Carbon\Carbon::parse($today->toDateString() . ' ' . $satta['extraFields']['open_time_morning'])
        : null;

      $morningEndTime = isset($satta['extraFields']['close_time_morning'])
        ? \Carbon\Carbon::parse($today->toDateString() . ' ' . $satta['extraFields']['close_time_morning'])
        : null;

      $eveningStartTime = isset($satta['extraFields']['open_time_evening'])
        ? \Carbon\Carbon::parse($today->toDateString() . ' ' . $satta['extraFields']['open_time_evening'])
        : null;

      $eveningEndTime = isset($satta['extraFields']['close_time_evening'])
        ? \Carbon\Carbon::parse($today->toDateString() . ' ' . $satta['extraFields']['close_time_evening'])
        : null;

      // Log parsed times to check if they are correct
      \Log::info("Now: {$now}");
      \Log::info("Evening Start: {$eveningStartTime}");
      \Log::info("Evening End: {$eveningEndTime}");

      // Check if the current time is between the start and end times for morning and evening
      $satta['isMorningOpen'] = $morningStartTime && $morningEndTime && $now->between($morningStartTime, $morningEndTime);
      $satta['isEveningOpen'] = $eveningStartTime && $eveningEndTime && $now->between($eveningStartTime, $eveningEndTime);

      // Log the result of the open checks
      \Log::info("Is Morning Open: {$satta['isMorningOpen']}");
      \Log::info("Is Evening Open: {$satta['isEveningOpen']}");
    }

    $exposer = BidTransaction::where('user_id', $user->user_id)
      ->where('status', 'submitted')
      ->whereNull('bid_result')
      ->get();

    // Return the view with the necessary data
    return view('Front', compact(
      'view',
      'homePage',
      'headerOption',
      'optionGame',
      'wallet',
      'user',
      'sattaGame',
      'exposer'
    ));
  }

  public function singlePage($slug, Request $request)
  {

    $post = Posts::where('posts.post_name', $slug)
      ->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
      ->leftJoin('users as user', 'user.user_id', 'posts.user_id')
      ->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
      ->where('posts.post_status', 'publish')
      ->get()->first();
    $relatedPosts = [];
    if ($post) {
      $postTypes = getPostType($post->post_type);
      $post->extraFields = getPostMeta($post->post_id);
      $post->posted_date = date('M d, Y', strtotime($post->created_at));
      $post->posted_time = date('h:i A', strtotime($post->created_at));
      $view = 'Templates.' . $post->post_template;
    } else {
      $view = 'Templates.NotFound';
      return view('NotFound', compact('view', 'post'));
    }

    return view('Front', compact('view', 'post', 'homePage'));
  }

  public function singlePost($post_type, $page, Request $request)
  {
    $post = Posts::where('posts.post_name', $page)
      ->leftJoin('posts as getImage', 'getImage.post_id', 'posts.guid')
      ->leftJoin('users as user', 'user.user_id', 'posts.user_id')
      ->select('posts.*', 'getImage.media as post_image', 'user.name as user_name', 'getImage.post_title as post_image_alt')
      ->where('posts.post_status', 'publish')
      ->get()->first();
    $relatedPosts = [];
    if ($post) {
      $post->extraFields = getPostMeta($post->post_id);
      $post->posted_date = date('M d, Y', strtotime($post->created_at));
      $post->posted_time = date('h:i A', strtotime($post->created_at));
      $termRelations = \App\Models\TermRelations::where('object_id', $post->post_id)->pluck('term_id')->toArray();

      if (!empty($post_type['taxonomy'])) {
        $termsSelected = [];
        foreach ($post_type['taxonomy'] as $key => $value) {
          $termsSelected[$key] = \App\Models\Terms::whereIn('id', $termRelations)->where('term_group', $key)->get();
        }
        $post->category = $termsSelected;
      }
      $category_name = \App\Models\Terms::where('id', $termRelations)->pluck('name')->first();
      $postedComments = \App\Models\Comment::where('post_id', $post->post_id)->where('comment_approved', 1)->get();
      foreach ($postedComments as &$postedComment) {
        $postedComment->rating = getCommentMeta($postedComment->comment_ID, 'comment_rating');
      }
      $post->postedComments = $postedComments;

      $relatedPosts = getPostsByPostType('post', '6', null, true, false, ['terms' => $termRelations, 'notPostId' => $post->post_id]);
      $view = 'Templates.' . $post->post_template;
    } else {
      $view = 'Templates.NotFound';
      return view('NotFound', compact('view', 'post'));
    }

    $user = getCurrentUser();
    if ($user->user_id == NULL) {
      $view = "Templates.Welcome";
      return view('Front', compact('view'));
    }

    $parentId = User::where('user_id', $user->user_id)->get()->first();
    $parentDetails = User::where('user_id', $parentId->parent)->get()->first();

    $bids = BidTransaction::where('game_id', $post->post_id)
      ->where('user_id', $user->user_id)
      ->where('status', 'pending')
      ->orderBy('created_at', 'DESC')
      ->get();

    $wallet = Wallet::where('user_id', $user->user_id)->first();

    $totalAmount = $bids->sum('bid_amount');
    $winAmount = $bids->sum('win_amount');

    return view('Front', compact('view', 'post', 'bids', 'user', 'totalAmount', 'wallet', 'winAmount', 'parentDetails'));
  }

  public function terms(Request $request, $categoryType, $slug)
  {
    $request->merge(['term' => $slug]);
    $blogs = getPostsByPostType('blog', 0, 'new',  true, true);
    $offices = getPostsByPostType('country', 3, 'new', true);
    $view = 'Templates.TermBlogs';
    return view('Front', compact('view', 'blogs', 'offices'));
  }

  public function optionGameList()
  {
    $user = getCurrentUser();
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $optionGame = getPostsByPostType('optiongame', 0, 'new', true);
    $view = 'Templates.OptionGameList';
    return view('Front', compact('view', 'optionGame', 'user', 'wallet'));
  }

  public function addMoneyPage()
  {
    $user = getCurrentUser();
    if ($user->user_id == NULL) {
      $view = "Templates.Welcome";
      return view('Front', compact('view'));
    }
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $requests = WalletTransactions::where('user_id', $user->user_id)->where('request_status', 'pending')->get();
    $view = 'Templates.AddMoney';
    return view('Front', compact('view', 'user', 'wallet', 'requests'));
  }

  public function moneyRequest(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => 'required',
        'wallet_id' => 'required',
        'utr_number' => 'nullable',
        'diposit_image' => 'nullable',
        'remark' => 'nullable',
        'deposit_amount' => 'required',
        'withdraw_amount' => 'nullable',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $transaction  = new WalletTransactions;
    $transaction->user_id = $request->user_id;
    $transaction->wallet_id = $request->wallet_id;
    $transaction->utr_number = $request->utr_number;
    $transaction->diposit_image = $request->diposit_image;
    $transaction->remark = $request->remark;
    $transaction->deposit_amount = $request->deposit_amount;
    $transaction->withdraw_amount = $request->withdraw_amount;
    $transaction->save();

    return redirect()->back()->with('success', 'Request Sent Successfully');
  }

  public function withdrawPage()
  {
    $user = getCurrentUser();
    if ($user->user_id == NULL) {
      $view = "Templates.Welcome";
      return view('Front', compact('view'));
    }
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $requests = WalletTransactions::where('user_id', $user->user_id)
      ->whereNotNull('withdraw_amount')
      ->get();
    $view = 'Templates.Withdraw';
    return view('Front', compact('view', 'user', 'wallet', 'requests'));
  }

  public function withdrawMoney(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => 'required',
        'wallet_id' => 'required',
        'withdraw_amount' => 'required',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $transaction  = new WalletTransactions;
    $transaction->user_id = $request->user_id;
    $transaction->wallet_id = $request->wallet_id;
    $transaction->withdraw_amount = $request->withdraw_amount;
    $transaction->save();

    return redirect()->back()->with('success', 'Request Sent Successfully');
  }

  public function profile()
  {
    $user = getCurrentUser();
    if ($user->user_id == NULL) {
      $view = "Templates.Welcome";
      return view('Front', compact('view'));
    }
    
    $exposer = BidTransaction::where('user_id', $user->user_id)
      ->where('status', 'submitted')
      ->whereNull('bid_result')
      ->get();

    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $view = 'Templates.Profile';
    return view('Front', compact('view', 'user', 'wallet', 'exposer'));
  }

  public function profileUpdate()
  {
    $user = getCurrentUser();
    if ($user->user_id == NULL) {
      $view = "Templates.Welcome";
      return view('Front', compact('view'));
    }
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $view = 'Templates.UpdateDetails';
    return view('Front', compact('view', 'user', 'wallet'));
  }

  public function myBids()
  {
    $user = getCurrentUser();
    $bids = BidTransaction::where('user_id', $user->user_id)
      ->where('status', 'submitted')
      ->orderBy('created_at', 'DESC')
      ->get();

    $wallet = Wallet::where('user_id', $user->user_id)->first();


    $view = 'Templates.MyBids';
    return view('Front', compact('view', 'bids', 'user', 'wallet'));
  }


  public function optionGameEntry(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => 'required',
        'game_id' => 'required',
        'answer' => 'required',

        'adminrate' => 'nullable',
        'subadmincommission' => 'nullable',

        'userrate' => 'nullable',
        'usercommission' => 'nullable',

        'bid_amount' => 'required',
        'harf_digit' => 'nullable',
      ]
    );

    if ($validator->fails()) {
      return redirect()->back()->withErrors($validator)->withInput();
    }

    $gameType = Posts::where('post_id', $request->game_id)->get()->first();

    if ($gameType->post_type === 'optiongame') {
      $slots = NULL;
    } else {
      $time = timeonly();
      if ($time <= '12:00:00') {
        $slots = 'morning';
      } else {
        $slots = 'evening';
      }
    }

    $user = getCurrentUser();
    $parent = User::where('user_id', $user->user_id)->get()->first();

    $winAmount = $request->userrate * $request->bid_amount;
    $winamount_from_admin = $request->adminrate * $request->bid_amount;

    $player_commission = $request->bid_amount * $request->usercommission / 100;
    $subadmin_amount = $request->bid_amount - $player_commission;

    $subadmin_commission = $request->bid_amount * $request->subadmincommission / 100;
    $admin_amount = $request->bid_amount - $subadmin_commission;

    $bid = new BidTransaction;
    $bid->user_id = $request->user_id;
    $bid->game_id = $request->game_id;
    $bid->parent_id = $parent->parent;
    $bid->answer = $request->answer;
    $bid->slot = $slots;
    $bid->harf_digit = $request->harf_digit ?? NULL;
    $bid->bid_amount = $request->bid_amount;
    $bid->win_amount = $winAmount;
    $bid->subadmin_amount = $subadmin_amount;
    $bid->player_commission = $player_commission;
    $bid->winamount_from_admin = $winamount_from_admin;
    $bid->admin_amount = $admin_amount;
    $bid->subadmin_commission = $subadmin_commission;
    $bid->save();

    return redirect()->back()->with('success', 'Bid Placed Successfully');
  }

  public function deleteBid($id)
  {
    $bid = BidTransaction::find($id);
    $bid->delete();
    return redirect()->back()->with('success', 'Bid Deleted Successfully');
  }

  public function submitAllBid(Request $request)
  {
    DB::beginTransaction();

    try {
      $bids = BidTransaction::where('user_id', $request->user_id)
        ->where('game_id', $request->game_id)
        ->where('status', 'pending')
        ->orderBy('created_at', 'DESC')
        ->get();

      if ($bids->isEmpty()) {
        return redirect()->route('myBids')->with('error', 'No pending bids found.');
      }

      $totalBidAmount = $bids->sum('bid_amount');
      $totalCommission = $bids->sum('player_commission');
      $totalAdminAmount = $bids->sum('admin_amount');

      // Update bid status
      BidTransaction::whereIn('id', $bids->pluck('id'))->update(['status' => 'submitted']);

      // Get game name
      $game = Posts::where('post_id', $request->game_id)->first();
      $gameName = $game->post_title ?? 'Unknown Game';

      // Get user & parent wallets
      $userWallet = Wallet::where('user_id', $request->user_id)->first();
      $parentWallet = Wallet::where('user_id', $request->parent_id)->first();
      $adminWallet = Wallet::where('user_id', 1)->first(); // Assuming Admin ID is 1

      if (!$userWallet || !$parentWallet || !$adminWallet) {
        return redirect()->route('myBids')->with('danger', 'Wallet not found.');
      }

      if ($userWallet->balance < $totalBidAmount) {
        return redirect()->route('myBids')->with('danger', 'Insufficient balance.');
      }

      // Debit from user & credit to parent
      $this->updateWallet($userWallet, -$totalBidAmount);
      $this->updateWallet($parentWallet, $totalBidAmount);
      $this->createTransaction($request->user_id, $request->parent_id, -$totalBidAmount, $userWallet->balance, "Bid on $gameName");
      $this->createTransaction($request->parent_id, $request->user_id, $totalBidAmount, $parentWallet->balance, "Received bid amount for $gameName");

      // Handle commission (Debit Parent, Credit User)
      $this->updateWallet($parentWallet, -$totalCommission);
      $this->updateWallet($userWallet, $totalCommission);
      $this->createTransaction($request->parent_id, $request->user_id, -$totalCommission, $parentWallet->balance, "$gameName Game Commission to User");
      $this->createTransaction($request->user_id, $request->parent_id, $totalCommission, $userWallet->balance, "$gameName Game Commission from Sub Admin");

      // Admin amount handling
      $this->updateWallet($parentWallet, -$totalAdminAmount);
      $this->updateWallet($adminWallet, $totalAdminAmount);
      $this->createTransaction($request->parent_id, 1, -$totalAdminAmount, $parentWallet->balance, "$gameName Game bid admin amount to Admin");
      $this->createTransaction(1, $request->parent_id, $totalAdminAmount, $adminWallet->balance, "$gameName Game bid amount received from Sub Admin");

      DB::commit();
      return redirect()->route('myBids')->with('success', 'All Bids Submitted Successfully');
    } catch (\Exception $e) {
      DB::rollBack();
      return redirect()->route('myBids')->with('danger', 'An error occurred: ' . $e->getMessage());
    }
  }

  private function updateWallet($wallet, $amount)
  {
    $wallet->balance += $amount;
    $wallet->save();
  }

  private function createTransaction($userId, $toFromId, $amount, $balance, $remark)
  {
    WalletTransactions::create([
      'user_id' => $userId,
      'tofrom_id' => $toFromId,
      'debit' => $amount < 0 ? abs($amount) : 0,
      'credit' => $amount > 0 ? $amount : 0,
      'balance' => $balance,
      'remark' => $remark,
      'created_at' => now(),
    ]);
  }


  public function cancelAllBid($game_id)
  {
    $user = getCurrentUser();
    $deletedRows = BidTransaction::where('user_id', $user->user_id)
      ->where('game_id', $game_id)
      ->where('status', 'pending')
      ->delete();

    if ($deletedRows > 0) {
      return redirect()->back()->with('success', 'All Bids Canceled Successfully');
    } else {
      return redirect()->back()->with('error', 'No Bids Found to Cancel');
    }
  }

  public function transaction()
  {
    $user = getCurrentUser();
    $wallet = Wallet::where('user_id', $user->user_id)->first();
    $list = WalletTransactions::where('user_id', $user->user_id)->get();

    $view = 'Templates.Transaction';
    return view('Front', compact('view', 'list', 'user', 'wallet'));
  }

  public function resultPage()
  {
    $user = getCurrentUser();
    $result = GameResult::all();
    $view = 'Templates.ResultPage';

    return view('Front', compact('view', 'result', 'user'));
  }

  public function pwsChange()
  {
    $user = getCurrentUser();
    $view = 'Templates.PasswordUpdate';
    $exposer = BidTransaction::where('user_id', $user->user_id)
      ->where('status', 'submitted')
      ->whereNull('bid_result')
      ->get();
      
    return view('Front', compact('view', 'user', 'exposer'));
  }

}
