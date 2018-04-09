<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class Role extends EntrustRole
{
    public function user()
    {
        return $this->belongsToMany('App\Models\User');
    }
}
