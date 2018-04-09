<?php
namespace App\Libraries\Facades;

use Illuminate\Support\Facades\Facade;

class Lang extends Facade {
    protected static function getFacadeAccessor() { 
        return 'Lang';     
    }
}
?>
