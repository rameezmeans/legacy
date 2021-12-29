<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{


	/**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'products';


    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'description',
        'image',
        'default_price',
        'status'
    ];

    /**
     * Get the order related to product
     *
     * @var array
    */
	public function order()
    {
        return $this->hasMany('App\Order','p_id');
    }

    /**
     * Get the order related to product
     *
     * @var array
    */
    public function pprice()
    {
        return $this->hasMany('App\Pprice','p_id');
    }
}
