<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailContent extends Model
{
    protected $table = 'email_content';
	protected $fillable = [
        'name', 'send_when', 'need_value', 'detail', 'language', 'updated_by'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}