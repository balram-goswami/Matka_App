<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

class SattaGameController extends Controller
{
    public function jodiSatta(Request $request)
    {
        $user = getCurrentUser();
        $post_id = $request->query('post_id');
        $post = getPostsByPostType('numberGame', 0, 'new', true)->where('post_id', $post_id)->first();
        $wallet = Wallet::where('user_id', $user->user_id)->first();
        $bids = BidTransaction::where('game_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
        $totalAmount = $bids->sum('bid_amount');

        $view = 'Templates.JodiSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount'));
    }

    public function oddEvenSatta(Request $request)
    {
        $user = getCurrentUser();
        $post_id = $request->query('post_id');
        $post = getPostsByPostType('numberGame', 0, 'new', true)->where('post_id', $post_id)->first();
        $wallet = Wallet::where('user_id', $user->user_id)->first();
        $bids = BidTransaction::where('game_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
        $totalAmount = $bids->sum('bid_amount');

        $view = 'Templates.OddEvenSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount'));
    }

    public function harfSatta(Request $request)
    {
        $user = getCurrentUser();
        $post_id = $request->query('post_id');
        $post = getPostsByPostType('numberGame', 0, 'new', true)->where('post_id', $post_id)->first();
        $wallet = Wallet::where('user_id', $user->user_id)->first();
        $bids = BidTransaction::where('game_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
        $totalAmount = $bids->sum('bid_amount');

        $view = 'Templates.HARFSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount'));
    }

    public function crossingSatta(Request $request)
    {
        $user = getCurrentUser();
        $post_id = $request->query('post_id');
        $post = getPostsByPostType('numberGame', 0, 'new', true)->where('post_id', $post_id)->first();
        $wallet = Wallet::where('user_id', $user->user_id)->first();
        $bids = BidTransaction::where('game_id', $post->post_id)
            ->where('user_id', $user->user_id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'DESC')
            ->get();
        $totalAmount = $bids->sum('bid_amount');

        $view = 'Templates.CrossingSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount'));
    }

    public function crossingGameEntry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'game_id' => 'required',
                'numbers' => 'required|string',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $numbers = array_unique(array_map('intval', explode(',', $request->numbers)));
        if (empty($numbers)) {
            return redirect()->back()->withErrors(['numbers' => 'Invalid input provided'])->withInput();
        }

        $combinations = [];
        foreach ($numbers as $i) {
            foreach ($numbers as $j) {
                if ($i !== $j) {
                    $combinations[] = $i . $j;
                }
            }
        }

        foreach ($combinations as $combination) {
            $bid = new BidTransaction;
            $bid->user_id = $request->user_id;
            $bid->game_id = $request->game_id;
            $bid->answer = $combination;
            $bid->bid_amount = 100;
            $bid->save();
        }

        return redirect()->back()->with('success', 'Bids Placed Successfully');
    }

    public function harfGameEntry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
              'user_id' => 'required',
              'game_id' => 'required',
              'answer' => 'required',
              'harf_digit' => 'required',
              'bid_amount' => 'required',
            ]
          );
      
          if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
          }
      
          $bid  = new BidTransaction;
          $bid->user_id = $request->user_id;
          $bid->game_id = $request->game_id;
          $bid->harf_digit = $request->harf_digit;
          $bid->answer = $request->answer;
          $bid->bid_amount = $request->bid_amount;
          $bid->save();
      
          return redirect()->back()->with('success', 'Bid Placed Successfully');
    }
}
