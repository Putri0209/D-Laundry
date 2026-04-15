<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Level extends Model
{
    use SoftDeletes;
    protected $table = 'levels';
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'level_name',
    ];

    public function users(){
        return $this->hasMany(User::class, 'level_id', 'id');
    }
}