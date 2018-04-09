<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'order';
	protected $guarded = ['id'];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
