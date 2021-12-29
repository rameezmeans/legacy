<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Addon extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'addons_name', 
        'hprice',
        'fprice', 
        'p_id'
    ];
}
