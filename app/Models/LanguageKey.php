<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Languagekey extends Model
{
    protected $table = 'lang_key';
    protected $fillable = [
        'name','code', 'updated_by'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
    public function lang_value() {
        return $this->hasMany('\App\Models\Languagevalue');
    }
}
