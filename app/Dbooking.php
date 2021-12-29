<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dbooking extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'dbooking_date',
        'dbooking_date',
        'dbooking_time_from',
        'dbooking_time_to' 
    ];
}
