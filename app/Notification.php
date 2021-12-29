<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    /**
     * Fillable fields
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'editor_id',
        'type',
        'value',
        'original_value',
        'approved',
        'created_at',
        'updated_at'
    ];
}
