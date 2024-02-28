<?php

use Illuminate\Support\Facades\Auth;

if (!function_exists('custom_asset')) {
    function custom_asset($path)
    {
        return '/nucleodashboard/public'.$path;
    }
}

if (!function_exists('photo_user')) {
    function photo_user($photo)
    {
        $url = '/nucleodashboard/storage/app/users/avatars/';
        if($photo != null)
            $url .= $photo;
        else
            $url .= 'default_avatar.png';
        return $url;
    }
}

if (!function_exists('str_decryptData')) {
    function str_decryptData($data){
        return \App\Http\Middleware\Cryptography::decrypt($data);
    }
}

if (!function_exists('str_encryptData')) {
    function str_encryptData($data){
        return \App\Http\Middleware\Cryptography::encrypt($data);
    }
}


if(!function_exists('validDocument')){
    function validDocument($document){
        return $document && ($document->is_valid && $document->is_complete);
    }
}

if (!function_exists('getIconStatusDocument')) {
    function getIconStatusDocument($document, $prop=null)
    {
        $iconPrefix = ($document->is_complete && $document->is_valid) ? 'gpp_good' : (($document->is_complete && !$document->is_valid) ? 'gpp_maybe' : 'gpp_bad');
        $iconColor = ($iconPrefix == 'gpp_good') ? '#0aa90a' : (($iconPrefix == 'gpp_maybe') ? '#f9bb00' : 'red');

        return "<span ".$prop['components']." class='material-symbols-outlined ".$prop['class']."' style='color: $iconColor; ".$prop['style']."'>$iconPrefix</span>";
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount, $currencyCode) {
        switch ($currencyCode) {
            case 'EUR':
                return '€ ' . number_format($amount, 2, ',', '.');
            case 'USD':
                return '$ ' . number_format($amount, 2, '.', ',');
            case 'AUD':
                return 'AU$ '. number_format($amount, 2, '.', ',');
            case 'BRL':
                return 'R$ ' . number_format($amount, 2, ',', '.');
            case 'CAD':
                return 'CA$ ' . number_format($amount, 2, '.', ',');
            case 'HKD':
                return 'HK$ ' . number_format($amount, 2, '.', ',');
            case 'NZD':
                return 'NZ$ ' . number_format($amount, 2, '.', ',');
            case 'SGD':
                return 'S$ ' . number_format($amount, 2, '.', ',');
            case 'RUB':
                return '₽ ' . number_format($amount, 2, ',', '');
            case 'GBP':
                return '£ ' . number_format($amount, 2, '.', ',');
            case 'CHF':
                return 'SFr ' . number_format($amount, 2, '.', ',');
            case 'CZK':
                return 'Kč ' . number_format($amount, 2, ',', ' ');
            case 'DKK':
                return 'kr ' . number_format($amount, 2, ',', ' ');
            case 'HUF':
                return 'Ft ' . number_format($amount, 0, '', ' ');
            case 'ILS':
                return '₪ ' . number_format($amount, 2, '.', ',');
            case 'JPY':
                return '¥ ' . number_format($amount, 0, '', '');
            case 'MXN':
                return 'MXN ' . number_format($amount, 2, '.', ',');
            case 'TWD':
                return 'NT$ ' . number_format($amount, 2, '.', ',');
            case 'NOK':
                return 'kr ' . number_format($amount, 2, ',', ' ');
            case 'PHP':
                return '₱ ' . number_format($amount, 2, '.', ',');
            case 'PLN':
                return 'zł ' . number_format($amount, 2, ',', ' ');
            case 'SEK':
                return 'kr ' . number_format($amount, 2, ',', ' ');
            case 'THB':
                return '฿ ' . number_format($amount, 2, '.', ',');
            default:
                return 'Unsupported Currency';
        }
    }
}

if (!function_exists('ageCalculator')) {
    function ageCalculator($birthDay) {
        $today = new DateTime();
        $birthDay = new DateTime($birthDay);
        $age = $today->diff($birthDay)->y;
        return $age;
    }
}

if (!function_exists('nextHappyBirthDay')) {
    function nextHappyBirthDay($currentBirthDay) {
        $birthDay = new DateTime($currentBirthDay);
        $birthDay->modify("+" . (ageCalculator($currentBirthDay) + 1) . " years");
        $nextBirthday = $birthDay->format('d/m/Y');
        if(date('d/m/Y') == (new DateTime($currentBirthDay))->modify("+" . ageCalculator($currentBirthDay)." years")->format('d/m/Y')){
            $nextBirthday = "Hoje!! 🥳🎉";
        }
        return $nextBirthday;
    }
}