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
                'subadminrate' => 'nullable',

                'adminshare' => 'nullable',
                'subadminshare' => 'nullable',
                'bid_amount' => 'required',
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

        $winAmount = $request->bid_amount * $request->adminrate;

        // admin money convert
        $totalrate = $request->adminshare + $request->subadminshare;
        $convert = $winAmount * 100 / $totalrate;
        $adminShare = $request->adminshare / 100 * $convert;
        $subadminShare = $winAmount - $adminShare;
        $adminsidewinAmount = $request->bid_amount * $totalrate;
        $subadminGet = $adminsidewinAmount - $winAmount;

        // Subadmin money convert
        $totalprofitrate = $request->adminrate + $request->subadminrate;
        $convertamount = $request->bid_amount * 100 / $totalprofitrate;
        $admin_cut = $request->adminrate / 100 * $convertamount;
        $subadmin_admin_cut = $request->subadminrate / 100 * $convertamount;

        foreach ($combinations as $combination) {
            $bid = new BidTransaction;
            $bid->user_id = $request->user_id;
            $bid->game_id = $request->game_id;
            $bid->answer = $combination;
            $bid->bid_amount = $request->bid_amount;
            $bid->admin_share = $adminShare;
            $bid->subadmin_share = $subadminShare;
            $bid->admin_cut = $admin_cut;
            $bid->subadmin_cut = $subadmin_admin_cut;
            $bid->subadminGet = $subadminGet;
            $bid->win_amount = $winAmount;
            $bid->parent_id = $parent->parent;
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
            'subadminrate' => 'nullable',

            'adminshare' => 'nullable',
            'subadminshare' => 'nullable',
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

                    $winAmount = $amount * $request->adminrate;

                    // admin money convert
                    $totalrate = $request->adminshare + $request->subadminshare;
                    $convert = $winAmount * 100 / $totalrate;
                    $adminShare = $request->adminshare / 100 * $convert;
                    $subadminShare = $winAmount - $adminShare;
                    $adminsidewinAmount = $amount * $totalrate;
                    $subadminGet = $adminsidewinAmount - $winAmount;

                    // Subadmin money convert
                    $totalprofitrate = $request->adminrate + $request->subadminrate;
                    $convertamount = $amount * 100 / $totalprofitrate;
                    $admin_cut = $request->adminrate / 100 * $convertamount;
                    $subadmin_admin_cut = $request->subadminrate / 100 * $convertamount;

                    BidTransaction::create([
                        'user_id' => $request->user_id,
                        'game_id' => $request->game_id,
                        'harf_digit' => 'Ander',
                        'answer' => $digit,
                        'bid_amount' => $amount,
                        'admin_share' => $adminShare,
                        'subadmin_share' => $subadminShare,
                        'admin_cut' => $admin_cut,
                        'subadmin_cut' => $subadmin_admin_cut,
                        'subadminGet' => $subadminGet,
                        'win_amount' => $winAmount,
                        'parent_id' => $parent->parent,
                    ]);
                }
            }
        }

        // Process Bahar Bids (Stored as Close)
        if (!empty($request->bahar)) {
            foreach ($request->bahar as $digit => $amount) {
                if (!empty($amount) && is_numeric($amount)) {

                    $winAmount = $amount * $request->adminrate;

                    // admin money convert
                    $totalrate = $request->adminshare + $request->subadminshare;
                    $convert = $winAmount * 100 / $totalrate;
                    $adminShare = $request->adminshare / 100 * $convert;
                    $subadminShare = $winAmount - $adminShare;
                    $adminsidewinAmount = $amount * $totalrate;
                    $subadminGet = $adminsidewinAmount - $winAmount;

                    // Subadmin money convert
                    $totalprofitrate = $request->adminrate + $request->subadminrate;
                    $convertamount = $amount * 100 / $totalprofitrate;
                    $admin_cut = $request->adminrate / 100 * $convertamount;
                    $subadmin_admin_cut = $request->subadminrate / 100 * $convertamount;
                    BidTransaction::create([
                        'user_id' => $request->user_id,
                        'game_id' => $request->game_id,
                        'harf_digit' => 'Bahar',
                        'answer' => $digit,
                        'bid_amount' => $amount,
                        'admin_share' => $adminShare,
                        'subadmin_share' => $subadminShare,
                        'admin_cut' => $admin_cut,
                        'subadmin_cut' => $subadmin_admin_cut,
                        'subadminGet' => $subadminGet,
                        'win_amount' => $winAmount,
                        'parent_id' => $parent->parent,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Bid Placed Successfully');
    }
}
