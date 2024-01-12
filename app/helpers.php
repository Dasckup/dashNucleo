<?php


if (!function_exists('custom_asset')) {
    function custom_asset($path)
    {
        if(env('APP_ENV')=="local"){
            return asset($path);
        }
        return '/public'.$path;
    }
}
