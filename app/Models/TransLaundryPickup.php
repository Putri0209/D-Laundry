<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransLaundryPickup extends Model
{
    protected $fillable = [
        'order_id', 'customer_id', 'pickup_date','notes'
    ];

    
}