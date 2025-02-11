<?php

namespace App\Services;

use App\Models\{
    User,
    UserDetails,
    Wallet
};


class UserService
{
    protected $service;
    protected $communicationService;
    public function __construct(User $user)
    {
        $this->service = $user;
    }
    public function table($type = null)
    {
        return $this->service->select('*');
    }
    public function representative()
    {
        return $this->service->where('role', 'representative')->get();
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
        $email = $request->input('email');
        $randomPassword = sha1(mt_rand(10000, 99999) . time() . $email);
        $password = $request->input('password') ?? $randomPassword;

        $service = $this->service;
        if ($request->file('photo')) {
            $mealService->photo = fileuploadExtra($request, 'photo');
        } elseif ($request->input('photo')) {
            $service->photo = $request->input('photo');
        }
        $service->name = $request->input('name');
        $service->email = $request->input('email');
        $service->phone = $request->input('phone');
        $service->parent = $request->input('parent');
        $service->toss_game = $request->input('toss_game');
        $service->crossing = $request->input('crossing');
        $service->harf = $request->input('harf');
        $service->odd_even = $request->input('odd_even');
        $service->jodi = $request->input('jodi');
        if ($password) {
            $service->password = bcrypt($password);
        }
        $service->email_verified_at = dateTime();
        $service->role = $request->input('role') ?? 'user';
        $service->save();

        if (!$wallet = Wallet::where('user_id', $service->id)->get()->first()) {
            $wallet = new Wallet();
            $wallet->user_id = $service->user_id;
            $wallet->balance = $request->input('balance') ?? '0';
            $wallet->created_at = dateTime();
            $wallet->save();

            $pWallet = Wallet::where('user_id', $request->input('parent'))->first();

            // Ensure the parent wallet exists and has sufficient balance
            if ($pWallet && $pWallet->balance >= $request->input('balance')) {
                $pWallet->decrement('balance', $request->input('balance'));
            } else {
                return redirect()->back()->withErrors(['error' => 'Insufficient balance in parent wallet.'])->withInput();
            }
        }

        return $service;
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
        $service->email = $request->input('email');
        $service->phone = $request->input('phone');
        $service->bank_name = $request->input('bank_name');
        $service->ac_holder_name = $request->input('ac_holder_name');
        $service->ac_number = $request->input('ac_number');
        $service->ifsc_code = $request->input('ifsc_code');
        $service->upi_one = $request->input('upi_one');
        $service->upi_two = $request->input('upi_two');
        $service->upi_three = $request->input('upi_three');
        $service->parent = $request->input('parent');
        $service->toss_game = $request->input('toss_game');
        $service->crossing = $request->input('crossing');
        $service->harf = $request->input('harf');
        $service->odd_even = $request->input('odd_even');
        $service->jodi = $request->input('jodi');
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
