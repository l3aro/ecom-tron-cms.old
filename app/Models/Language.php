<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    // protected $_lang = '';
    protected $table = 'lang';
    protected $fillable = [
        'name','short_name','image'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
