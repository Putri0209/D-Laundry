<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    const STATUS_IN_ON_TIME ='on_time';
    const STATUS_IN_LATE ='late';

    const CHECK_IN_TIME = '08:00';
    const CHECK_OUT_TIME = '14:00';
    protected $fillable = [
        'student_id',
        'date',
        'check_in',
        'check_out',
        'status_in',
        'status_out',
        'note'
    ];

    public function student(){
        return $this->belongsTo(Student::class);
    }
}