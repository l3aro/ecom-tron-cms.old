<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orderdetail extends Model
{
    protected $table = 'order_detail';
    protected $fillable = [
        'order_id','product_id','quantity','price','total'
    ];
    protected $dates = [
        'created_at','updated_at'
    ];
}
