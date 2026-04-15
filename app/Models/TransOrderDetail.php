<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransOrderDetail extends Model
{
    protected $fillable = [
        'order_id', 'service_id', 'qty','subtotal', 'notes'
    ];

    public function service(){
        return $this->hasMany(TypeOfService::class, 'services_id', 'id');
    }
}