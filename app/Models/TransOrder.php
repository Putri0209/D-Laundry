<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;

class TransOrder extends Model
{
    protected $fillable = [
        'customer_id','order_code','order_date', 'order_end_date', 'order_status', 'order_pay', 'order_change', 'total'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}