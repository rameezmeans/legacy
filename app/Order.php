<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{


	/**
     * The database table used by the model.
     *
     * @var string
    */
    protected $table = 'orders';


    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'booking_date',
        'booking_time_from',
        'booking_time_to',
        'time_html',
        'name',
        'phone',
        'email',
        'booking_details',
        'location_details',
        'buffet_details',
        'tray_details',
        'bar_details',
        'bottle_details',
        'bartender_details',
        'addon_details',
        'stotal',
        'total',
        'discount',
        'due',
        'tax',
        'c_id',
        'u_id',
        'p_id',
        'status',
		'paystatus',
		'paymethod',
		'payadvance',
        'paywith',
        'payid',
        'token',
        'payerid',
        'cancel_by',
        'parent_id',
        'next_day'
    ];

    /**
     * Get the product belongs to this order
     *
     * @var array
    */
	public function product()
    {
        return $this->belongsTo('App\Product','p_id');
    }
}
