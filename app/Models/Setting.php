<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'setting';
	protected $guarded = ['id'];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
