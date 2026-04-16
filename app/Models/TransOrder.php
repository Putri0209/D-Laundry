<?php

namespace App\Models;

use App\Models\Customer;
use App\Models\TransLaundryPickup;
use App\Models\TransOrderDetail;
use Illuminate\Database\Eloquent\Model;

class TransOrder extends Model
{
    protected $fillable = [
        'customer_id','order_code','order_date', 'order_end_date', 'order_status', 'order_pay', 'order_change', 'tax', 'total'
    ];
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function details()
{
    return $this->hasMany(TransOrderDetail::class, 'order_id', 'id');
}
public function pickup()
{
    return $this->hasOne(TransLaundryPickup::class, 'order_id', 'id');
}
}