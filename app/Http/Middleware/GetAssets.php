<?php
namespace App\Http\Middleware;

class URL{
    static public function assets($uri){
        return env('APP_URL').env('APP_ASSETS_PHAR').$uri;
    }
}
