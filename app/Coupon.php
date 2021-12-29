<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'coupon_name', 
        'start_date',
        'end_date', 
        'discount', 
        'p_id'
    ];
}
