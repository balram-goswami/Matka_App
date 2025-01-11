<?php

namespace App\Services;

use App\Models\{
    User,
    UserDetails
};

class UserDetailsService
{
    protected $service;
    protected $communicationService;
    public function __construct(UserDetails $userDetails)
    {
        $this->service = $userDetails;
    }
    public function table($type = null)
    {
        return $this->service->select('*');
    }
    public function select()
    {
        return $this->service;
    }
    public function paginate($request)
    {
        return $this->service->paginate(pagination($request->per_page));
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
        if ($password) {
            $service->password = bcrypt($password);
        }
        $service->role = $request->input('role');
        $service->save();

        return $service;
    }
    
}
