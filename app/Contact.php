<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'company',
        'dayofevent',
        'additional',
        'category'
    ];
}
