<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pprice extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'day',
        'date',
        'price',
        'p_id'
    ];

    
    /**
     * Get the product belongs to this pricing
     *
     * @var array
    */
    public function product()
    {
        return $this->belongsTo('App\Product','p_id');
    }
}
