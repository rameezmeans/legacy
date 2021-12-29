<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Beverage extends Model
{
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'beverage_name',  
        'hprice',
        'fprice',
        'p_id'
    ];
}
