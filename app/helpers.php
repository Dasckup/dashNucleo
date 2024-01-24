<?php


if (!function_exists('custom_asset')) {
    function custom_asset($path)
    {
        return '/public'.$path;
    }
}
