<?php

namespace App\Http\Controllers\Player;

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

        $parentId = User::where('user_id', $user->user_id)->get()->first();
        $parentDetails = User::where('user_id', $parentId->parent)->get()->first();

        $winAmount = $bids->sum('win_amount');

        $view = 'Templates.JodiSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount', 'parentDetails', 'winAmount'));
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

        $parentId = User::where('user_id', $user->user_id)->get()->first();
        $parentDetails = User::where('user_id', $parentId->parent)->get()->first();

        $winAmount = $bids->sum('win_amount');
        $view = 'Templates.OddEvenSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount', 'parentDetails', 'winAmount'));
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

        $parentId = User::where('user_id', $user->user_id)->get()->first();
        $parentDetails = User::where('user_id', $parentId->parent)->get()->first();

        $winAmount = $bids->sum('win_amount');
        $view = 'Templates.HARFSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount', 'parentDetails', 'winAmount'));
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

        $parentId = User::where('user_id', $user->user_id)->get()->first();
        $parentDetails = User::where('user_id', $parentId->parent)->get()->first();

        $winAmount = $bids->sum('win_amount');
        $view = 'Templates.CrossingSatta';
        return view('Front', compact('view', 'user', 'post', 'wallet', 'bids', 'totalAmount', 'parentDetails', 'winAmount'));
    }

    public function crossingGameEntry(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required',
                'game_id' => 'required',
                'numbers' => 'required|string',
                'bid_amount' => 'required',

                'adminrate' => 'nullable',
                'subadmincommission' => 'nullable',

                'userrate' => 'nullable',
                'usercommission' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $numbers = array_unique(array_map('intval', explode(',', $request->numbers)));
        if (empty($numbers)) {
            return redirect()->back()->withErrors(['numbers' => 'Invalid input provided'])->withInput();
        }
        $user = getCurrentUser();
        $parent = User::where('user_id', $user->user_id)->get()->first();

        $combinations = [];
        foreach ($numbers as $i) {
            foreach ($numbers as $j) {
                if ($i !== $j) {
                    $combinations[] = $i . $j;
                }
            }
        }

        $winAmount = $request->userrate * $request->bid_amount;
        $winamount_from_admin = $request->adminrate * $request->bid_amount;

        $player_commission = $request->bid_amount * $request->usercommission / 100;
        $subadmin_amount = $request->bid_amount - $player_commission;

        $subadmin_commission = $request->bid_amount * $request->subadmincommission / 100;
        $admin_amount = $request->bid_amount - $subadmin_commission;

        $diff = $request->userrate - $request->adminrate;
        $subadminDiff = $request->bid_amount / 100 * $diff;
        $adminDiff = $request->bid_amount / 100 * $request->adminrate;


        foreach ($combinations as $combination) {
            $bid = new BidTransaction;
            $bid->user_id = $request->user_id;
            $bid->game_id = $request->game_id;
            $bid->parent_id = $parent->parent;
            $bid->answer = $combination;
            $bid->harf_digit = $request->harf_digit ?? NULL;
            $bid->bid_amount = $request->bid_amount;
            $bid->win_amount = $winAmount;
            $bid->subadmin_amount = $subadmin_amount;
            $bid->player_commission = $player_commission;
            $bid->winamount_from_admin = $winamount_from_admin;
            $bid->admin_amount = $admin_amount;
            $bid->admin_dif = $adminDiff;
            $bid->subadmin_dif = $subadminDiff;
            $bid->subadmin_commission = $subadmin_commission;
            $bid->save();
        }

        return redirect()->back()->with('success', 'Bids Placed Successfully');
    }

    public function harfGameEntry(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'game_id' => 'required',

            'adminrate' => 'nullable',
            'subadmincommission' => 'nullable',

            'userrate' => 'nullable',
            'usercommission' => 'nullable',

            'ander' => 'nullable|array',
            'baahr' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $user = getCurrentUser();
        $parent = User::where('user_id', $user->user_id)->get()->first();

        // Process Ander Bids (Stored as Open)
        if (!empty($request->ander)) {
            foreach ($request->ander as $digit => $amount) {
                if (!empty($amount) && is_numeric($amount)) {


                    $winAmount = $request->userrate * $amount;
                    $winamount_from_admin = $request->adminrate * $amount;

                    $player_commission = $amount * $request->usercommission / 100;
                    $subadmin_amount = $amount - $player_commission;

                    $subadmin_commission = $amount * $request->subadmincommission / 100;
                    $admin_amount = $amount - $subadmin_commission;

                    $diff = $request->userrate - $request->adminrate;
                    $getDiff = $diff * 10;
                    $adminrate = $request->adminrate*10;
                    $subadminDiff = $amount / 100 * $getDiff;
                    $adminDiff = $amount / 100 * $adminrate;

                    $bid = new BidTransaction;
                    $bid->user_id = $request->user_id;
                    $bid->game_id = $request->game_id;
                    $bid->parent_id = $parent->parent;
                    $bid->answer = $digit;
                    $bid->harf_digit = 'Andar';
                    $bid->bid_amount = $amount;
                    $bid->win_amount = $winAmount;
                    $bid->subadmin_amount = $subadmin_amount;
                    $bid->player_commission = $player_commission;
                    $bid->winamount_from_admin = $winamount_from_admin;
                    $bid->admin_amount = $admin_amount;
                    $bid->admin_dif = $adminDiff;
                    $bid->subadmin_dif = $subadminDiff;
                    $bid->subadmin_commission = $subadmin_commission;
                    $bid->save();
                }
            }
        }

        // Process Bahar Bids (Stored as Close)
        if (!empty($request->bahar)) {
            foreach ($request->bahar as $digit => $amount) {
                if (!empty($amount) && is_numeric($amount)) {

                    $winAmount = $request->userrate * $amount;
                    $winamount_from_admin = $request->adminrate * $amount;

                    $player_commission = $amount * $request->usercommission / 100;
                    $subadmin_amount = $amount - $player_commission;

                    $subadmin_commission = $amount * $request->subadmincommission / 100;
                    $admin_amount = $amount - $subadmin_commission;

                    $diff = $request->userrate - $request->adminrate;
                    $getDiff = $diff * 10;
                    $adminrate = $request->adminrate*10;
                    $subadminDiff = $amount / 100 * $getDiff;
                    $adminDiff = $amount / 100 * $adminrate;

                    $bid = new BidTransaction;
                    $bid->user_id = $request->user_id;
                    $bid->game_id = $request->game_id;
                    $bid->parent_id = $parent->parent;
                    $bid->answer = $digit;
                    $bid->harf_digit = 'Bahar';
                    $bid->bid_amount = $amount;
                    $bid->win_amount = $winAmount;
                    $bid->subadmin_amount = $subadmin_amount;
                    $bid->player_commission = $player_commission;
                    $bid->winamount_from_admin = $winamount_from_admin;
                    $bid->admin_amount = $admin_amount;
                    $bid->admin_dif = $adminDiff;
                    $bid->subadmin_dif = $subadminDiff;
                    $bid->subadmin_commission = $subadmin_commission;
                    $bid->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Bid Placed Successfully');
    }
}
