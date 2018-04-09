<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $table = 'video';
    protected $guarded = ['id'];
    protected $dates = [
        'created_at', 'updated_at'
    ];
    public function video_cat() {
        return $this->belongsTo('App\Models\Videocat', 'cat');
    }
    public function videoUpdateBy() {
        return $this->belongsTo('App\Models\User', 'updated_by');
	}
}
