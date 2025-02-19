<?php

namespace App\Services;

use App\Models\{
    User,
    Wallet,
    WalletTransactions
};


class UserService
{
    protected $service;
    protected $walletService;
    public function __construct(User $user, Wallet $walletService)
    {
        $this->service = $user;
        $this->walletService = $walletService;
    }
    public function table($type = null)
    {
        return $this->service->select('*');
    }
    public function walletService($type = null)
    {
        return $this->walletService->select('*');
    }
    public function select()
    {
        return $this->service;
    }
    public function paginate($request)
    {
        return $this->service->paginate(pagination($request->per_page));
    }
    public function helperList()
    {
        $status = commonStatus();
        $userTypes = userTypes();
        return compact('status', 'userTypes');
    }
    public function store($request)
    {
        if ($request->input('role') === 'subadmin') {
            $pWallet = Wallet::where('user_id', 1)->first();
        } else {
            $pWallet = Wallet::where('user_id', $request->input('parent'))->first();
        }

        if ($pWallet->balance >= $request->input('balance')) {

            $service = $this->service;
            $service->name = $request->input('name');
            $password = $request->input('password');

            $service->parent = $request->input('parent');
            $service->admin_cut_toss_game = $request->input('admin_cut_toss_game');
            $service->admin_cut_crossing = $request->input('admin_cut_crossing');
            $service->admin_cut_harf = $request->input('admin_cut_harf');
            $service->admin_cut_odd_even = $request->input('admin_cut_odd_even');
            $service->admin_cut_jodi = $request->input('admin_cut_jodi');

            $service->user_cut_toss_game = $request->input('user_cut_toss_game');
            $service->user_cut_crossing = $request->input('user_cut_crossing');
            $service->user_cut_harf = $request->input('user_cut_harf');
            $service->user_cut_odd_even = $request->input('user_cut_odd_even');
            $service->user_cut_jodi = $request->input('user_cut_jodi');
            if ($password) {
                $service->password = bcrypt($password);
            }
            $service->email_verified_at = dateTime();
            $service->role = $request->input('role') ?? 'player';
            $service->status = $request->input('status') ?? 'Active';
            $service->save();

            if (!$wallet = Wallet::where('user_id', $service->id)->get()->first()) {
                $wallet = new Wallet();
                $wallet->user_id = $service->user_id;
                $wallet->balance = $request->input('balance') ?? '0';
                $wallet->created_at = dateTime();
                $wallet->save();

                $pWallet->balance = $pWallet->balance - $request->input('balance');
                $pWallet->save();

                $TransactionsUser = new WalletTransactions();
                $TransactionsUser->user_id = $service->user_id;
                $TransactionsUser->tofrom_id = 1;
                $TransactionsUser->credit = $request->input('balance');
                $TransactionsUser->balance = $wallet->balance;
                $TransactionsUser->remark = 'Credited by ';
                $TransactionsUser->created_at = dateTime();
                $TransactionsUser->save();

                $TransactionsAdmin = new WalletTransactions();
                $TransactionsAdmin->user_id = 1;
                $TransactionsAdmin->tofrom_id = $service->user_id;
                $TransactionsAdmin->debit = $request->input('balance');
                $TransactionsAdmin->balance = $pWallet->balance;
                $TransactionsAdmin->remark = 'Debited to User';
                $TransactionsAdmin->created_at = dateTime();
                $TransactionsAdmin->save();
            }
            
        $newUser = User::latest()->first();
        return redirect()->back()->with('success', "New User (ID: {$newUser->name}) saved successfully.");
        return $service;
        } else {
            return redirect()->back()->with('danger', 'Insufficient balance in parent wallet.');
        }
    }
    public function get($id = null)
    {
        return $this->service->find($id);
    }
    public function getUserByEmail($emailId)
    {
        return $this->service->whereEmail($emailId)->get()->first();
    }
    public function update($request, $service)
    {
        if (!is_object($service)) {
            $service = $this->get($service);
        }
        $password = $request->input('password');
        if ($request->file('photo')) {
            $mealService->photo = fileuploadExtra($request, 'photo');
        } elseif ($request->input('photo')) {
            $service->photo = $request->input('photo');
        }
        $service->name = $request->input('name');

        $service->bank_name = $request->input('bank_name');
        $service->ac_holder_name = $request->input('ac_holder_name');
        $service->ac_number = $request->input('ac_number');
        $service->ifsc_code = $request->input('ifsc_code');
        $service->upi_one = $request->input('upi_one');
        $service->upi_two = $request->input('upi_two');
        $service->upi_three = $request->input('upi_three');

        $service->parent = $request->input('parent');
        $service->admin_cut_toss_game = $request->input('admin_cut_toss_game');
        $service->admin_cut_crossing = $request->input('admin_cut_crossing');
        $service->admin_cut_harf = $request->input('admin_cut_harf');
        $service->admin_cut_odd_even = $request->input('admin_cut_odd_even');
        $service->admin_cut_jodi = $request->input('admin_cut_jodi');
        $service->user_cut_toss_game = $request->input('user_cut_toss_game');
        $service->user_cut_crossing = $request->input('user_cut_crossing');
        $service->user_cut_harf = $request->input('user_cut_harf');
        $service->user_cut_odd_even = $request->input('user_cut_odd_even');
        $service->user_cut_jodi = $request->input('user_cut_jodi');
        $service->status = $request->input('status');
        if ($password) {
            $service->password = bcrypt($password);
        }
        $service->role = $request->input('role');
        $service->save();

        return $service;
    }

    public function delete($service = null)
    {
        if (!is_object($service)) {
            $service = $this->get($service);
        }
        $service->delete();
        return $service;
    }
    public function updateStatus($request)
    {
        $this->get($request->userId)->update(['status' => $request->status]);
    }
}
