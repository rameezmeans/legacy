<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
   /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'food_name',
        'type',
        'price',
        'p_id'
    ];
}
