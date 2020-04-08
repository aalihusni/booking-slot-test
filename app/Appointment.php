<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'appointment';

    protected $fillable = [
        'first_name',
        'last_name',
        'car_plate',
        'inspection_time_start',
        'inspection_time_end',
        'inspection_slot'
    ];
}
