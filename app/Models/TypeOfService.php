<?php

namespace App\Models;

use App\Models\TransOrderDetail;
use Illuminate\Database\Eloquent\Model;

class TypeOfService extends Model
{
    protected $fillable = [
        'service_name', 'price', 'description'
    ];

    public function details(){
        return $this->belongsTo(TransOrderDetail::class, 'service_id', 'id');
    }
}