<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bottle extends Model
{
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [
        'bottle_name',  
        'price',
        'p_id'
    ];
}
