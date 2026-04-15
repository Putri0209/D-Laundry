<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_name', 'phone', 'address'
    ];

    public function order(){
        return $this->hasMany(TransOrder::class, 'customer_id', 'id');
    }
}