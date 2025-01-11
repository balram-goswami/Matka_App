<?php

namespace App\Services;

use App\Models\{
    Transactions
};
use App\Services\CommunicationService;
use App\Http\Resources\PaginationResource;

class TransactionService extends PaginationResource
{
    protected $transactions;
    protected $communicationService;
    public function __construct(Transactions $transactions) {
        $this->transactions = $transactions;
    }
    public function store($order, $response)
    {
        $transactions = $this->transactions;
        $transactions->transaction_auto_id = rand(111111, 999999);
        $transactions->meal_id = $order->meal_id;
        $transactions->user_id = $order->user_id;
        $transactions->order_id = $order->id;
        $transactions->payment_id = $response->id;
        $transactions->payment_method = 'Yoco';
        $transactions->status = 'Done';
        $transactions->payment_raw = maybe_encode($response);
        $transactions->payment_date = date('Y-m-d');
        $transactions->payment_time = date('H:i:s');
        $transactions->created_at = dateTime();
        $transactions->updated_at = dateTime();        
        $transactions->save();

        $transactions->transaction_auto_id = $transactions->transaction_auto_id.$transactions->id;
        $transactions->save();

        return $transactions;
    }
}