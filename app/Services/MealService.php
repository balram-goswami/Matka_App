<?php

namespace App\Services;

use App\Models\{
    Meals,
    MealOptions
};
use App\Services\CommunicationService;
use App\Http\Resources\PaginationResource;

class MealService extends PaginationResource
{
    protected $mealService;
    protected $mealOptionService;
    protected $communicationService;
    public function __construct(Meals $meals, MealOptions $mealOptions, CommunicationService $communicationService) {
        $this->mealService = $meals;
        $this->mealOptionService = $mealOptions;
        $this->communicationService = $communicationService;
    }
    public function table($type = null) {
        return $this->mealService->select('*')->orderBy('id', 'DESC')->with('user');
    }
    public function paginate($request) {
        $currentUser = getCurrentUser();
        $response = $this->mealService->where('user_id', $currentUser->user_id)->orderBy('id', 'DESC')->paginate(pagination($request->per_page));
        return parent::jsonResponse($response);
    }
    public function store($request)
    {
        $currentUser = getCurrentUser();
        $lastMealAutoId = ($this->mealService->where('user_id', $currentUser->user_id)->orderBy('id', 'DESC')->get()->pluck('meal_auto_id')->first()??0)+1;
        $mealService = $this->mealService;
        $mealService->meal_auto_id = $lastMealAutoId;
        $mealService->user_id = $currentUser->user_id;
        $mealService->title = $request->title??'Meal '.$lastMealAutoId;
        $slug = str_slug($mealService->title.'-'.$lastMealAutoId.rand(111111, 999999));
        $mealService->slug = $slug;
        $mealService->url = 'meal_customer_view/'.$slug;
        $mealService = $this->mapFields($mealService, $request);
        $mealService->created_at = dateTime();
        
        $mealService->save();

        $this->insertUpdateMealOptions($mealService, $request, $currentUser);

        $name = $currentUser->name;
        $email = $currentUser->email;
        $emailSubject = 'Meal Createt at '.appName();
        $emailBody = view('Email.SendMealCreatedNotify', compact('name'));
        $this->communicationService->mail($email, $emailSubject, $emailBody);
        return $mealService;
    }
    public function get($id = null) {
        return $this->mealService->with(['meal_options', 'user'])->find($id);
    }
    public function getMealByUrl($url) {
        return $this->mealService->where(function($query) use ($url) {
            $query->orWhere('slug', $url)->orWhere('url', $url);
        })->with(['meal_options', 'user'])->get()->first();
    }
    public function update($request, $mealService) {       
        if(!is_object($mealService)) {
            $mealService = $this->get($mealService);
        }
        $currentUser = getCurrentUser();
        $mealService = $this->mapFields($mealService, $request);
        $mealService->save();
        $this->insertUpdateMealOptions($mealService, $request, $currentUser);
        return $mealService;
    }
    public function insertUpdateMealOptions($mealService, $request, $currentUser) {
        $mealOptions = $request->meal_options;
        if (is_array($mealOptions) && !empty($mealOptions)) {
            foreach ($mealOptions as $mealOption) {
                if (!$dbMealOption = MealOptions::where('meal_id', $mealService->id)->where('id', (isset($mealOption['id'])?$mealOption['id']:''))->get()->first()) {
                    $dbMealOption = new MealOptions();
                    $dbMealOption->meal_id = $mealService->id;
                    $dbMealOption->user_id = $currentUser->user_id;
                    $dbMealOption->created_at = dateTime();
                }
                $dbMealOption->meal_type = (isset($mealOption['meal_type'])?$mealOption['meal_type']:'');
                $dbMealOption->quantity_limit = (isset($mealOption['quantity_limit'])?$mealOption['quantity_limit']:'');
                $dbMealOption->price = (isset($mealOption['price'])?$mealOption['price']:'');
                $dbMealOption->updated_at = dateTime();
                $dbMealOption->save();
            }
        }
    }
    public function mapFields($mealService, $request){
        if ($request->file('media')) {
            $mealService->media = fileuploadExtra($request, 'media');
        }
        $mealService->description = $request->input('description');
        $mealService->status = $request->input('status');
        $mealService->max_quantity = $request->input('max_quantity');
        $mealService->meal_date = $request->input('meal_date')?date('Y-m-d', strtotime($request->input('meal_date'))):null;
        $mealService->pickup_from = $request->input('pickup_from');
        $mealService->pickup_to = $request->input('pickup_to');
        $mealService->delivery_from = $request->input('delivery_from');
        $mealService->delivery_to = $request->input('delivery_to');
        $mealService->pay_online = $request->input('pay_online')??'0';
        $mealService->pay_offline = $request->input('pay_offline')??'0';
        $mealService->closing_time = $request->input('closing_time')?date('H:i:s', strtotime($request->input('closing_time'))):null;
        $mealService->enable_sms_client = $request->input('enable_sms_client')??'0';
        $mealService->enable_sms_customer = $request->input('enable_sms_customer')??'0';
        $mealService->updated_at = dateTime();

        return $mealService;
    }
    public function delete($mealService = null)
    {
        if(!is_object($mealService)) {
            $mealService = $this->get($mealService);
        }
        $mealService->delete();
        MealOptions::where('meal_id', $mealService->id)->delete();
        return $mealService;
    }
}