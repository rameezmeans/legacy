<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /**
     * Fillable fields
     * 
     * @var array
     */
    protected $fillable = [ 
        'hprice',
        'fprice',
        'tax'  
    ];
}
