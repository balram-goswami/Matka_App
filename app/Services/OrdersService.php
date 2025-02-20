<?php

namespace App\Services;

use App\Models\{
    CustomerOrders,
    CustomerOrderItems,
    User,
    Meals,
    MealOptions
};
use App\Services\CommunicationService;
use App\Http\Resources\PaginationResource;

class OrdersService extends PaginationResource
{
    protected $customerOrders;
    protected $customerOrderItems;
    protected $communicationService;
    public function __construct(CustomerOrders $customerOrders, CustomerOrderItems $customerOrderItems, CommunicationService $communicationService) {
        $this->customerOrders = $customerOrders;
        $this->customerOrderItems = $customerOrderItems;
        $this->communicationService = $communicationService;
    }
    public function table($type = null) {
        return $this->customerOrders->select('*')->orderBy('id', 'DESC')->with(['user','meal']);
    }
    public function paginate($request) {
        $currentUser = getCurrentUser();
        $response = $this->customerOrders->where('user_id', $currentUser->user_id)->orderBy('id', 'DESC')->paginate(pagination($request->per_page));
        return parent::jsonResponse($response);
    }
    public function store($request)
    {
        $customerOrders = $this->customerOrders;
        $customerOrders->order_id = rand(111111, 999999);
        $customerOrders->user_id = $request->user_id;
        $customerOrders->meal_id = $request->meal_id;
        $customerOrders->status = 'Pending';
        $customerOrders->payment_status = 'Pending';

        $customerOrders->payment_method = $request->payment_method;
        $customerOrders->order_time = $request->order_time;
        $customerOrders->order_type = $request->order_type;
        $customerOrders->created_at = dateTime();
        
        $customerOrders->save();

        $grandTotal = $this->insertUpdateOrderOptions($customerOrders, $request);

        $customerOrders->sub_total = $grandTotal;
        $customerOrders->grand_total = $grandTotal;
        $customerOrders->order_id = $customerOrders->order_id.$customerOrders->id;
        $customerOrders->save();

        $user = User::find($request->user_id);
        $name = $user->name;
        $email = $user->email;
        $emailSubject = 'Meal Createt at '.appName();
        $emailBody = view('Email.SendOrderCreatedNotify', compact('name', 'customerOrders'));
        $this->communicationService->mail($email, $emailSubject, $emailBody);
        return $customerOrders;
    }
    public function get($id = null) {
        return $this->customerOrders->with(['items.meal_option', 'meal', 'user'])->where('order_id', $id)->get()->first();
    }
    public function getGrandTotal($request) {
        $items = $request->items;
        $grandTotal = 0;
        if (is_array($items) && !empty($items)) {
            foreach ($items as $item) {
                $mealOption = MealOptions::find($item['id']);
                $total_price = $mealOption->price*$item['quantity'];
                $grandTotal += $total_price;
            }
        }
        return $grandTotal;
    }
    public function insertUpdateOrderOptions($customerOrders, $request) {
        $items = $request->items;
        $grandTotal = 0;
        if (is_array($items) && !empty($items)) {
            foreach ($items as $item) {
                $mealOption = MealOptions::find($item['id']);
                $total_price = $mealOption->price*$item['quantity'];
                $grandTotal += $total_price;
                $dbOrderOption = new CustomerOrderItems();
                $dbOrderOption->order_id = $customerOrders->id;
                $dbOrderOption->user_id = $request->user_id;
                $dbOrderOption->meal_id = $request->meal_id;
                $dbOrderOption->meal_option_id = $item['id'];
                $dbOrderOption->quantity = $item['quantity'];
                $dbOrderOption->meal_type = $mealOption->meal_type;
                $dbOrderOption->base_price = $mealOption->price;
                $dbOrderOption->total_price = $total_price;
                $dbOrderOption->status = 'Pending';
                $dbOrderOption->created_at = dateTime();
                $dbOrderOption->updated_at = dateTime();
                $dbOrderOption->save();
            }
        }
        return $grandTotal;
    }
    public function mapFields($customerOrders, $request){
        if ($request->file('media')) {
            $customerOrders->media = fileuploadExtra($request, 'media');
        }
        $customerOrders->description = $request->input('description');
        $customerOrders->status = $request->input('status');
        $customerOrders->max_quantity = $request->input('max_quantity');
        $customerOrders->meal_date = $request->input('meal_date')?date('Y-m-d', strtotime($request->input('meal_date'))):null;
        $customerOrders->pickup_from = $request->input('pickup_from');
        $customerOrders->pickup_to = $request->input('pickup_to');
        $customerOrders->pay_online = $request->input('pay_online')??'0';
        $customerOrders->pay_offline = $request->input('pay_offline')??'0';
        $customerOrders->closing_time = $request->input('closing_time')?date('H:i:s', strtotime($request->input('closing_time'))):null;
        $customerOrders->enable_sms_client = $request->input('enable_sms_client')??'0';
        $customerOrders->enable_sms_customer = $request->input('enable_sms_customer')??'0';
        $customerOrders->updated_at = dateTime();

        return $customerOrders;
    }
    public function delete($customerOrders = null)
    {
        if(!is_object($customerOrders)) {
            $customerOrders = $this->get($customerOrders);
        }
        $customerOrders->delete();
        MealOptions::where('meal_id', $customerOrders->id)->delete();
        return $customerOrders;
    }
}