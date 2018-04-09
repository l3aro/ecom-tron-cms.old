<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Languagevalue extends Model
{
    protected $table = 'lang_value';
    protected $fillable = [
        'lang','idlangkey','key_code','value','updated_by'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function lang_key() {
        return $this->belongsTo('App\Models\Languagekey');
    }
}
