<?php
namespace App\Http\Middleware;


class OnCurrencyFormatter {
    public static function formatCurrency($amount, $currencyCode) {
        switch ($currencyCode) {
            case 'EUR':
                return '€ ' . number_format($amount, 2, ',', '.');
            case 'USD':
                return '$ ' . number_format($amount, 2, '.', ',');
            case 'AUD':
                return 'AU$ '. number_format($amount, 2, '.', ',');
            case 'BRL':
                return 'R$ ' . number_format($amount, 2, '.', ',');
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
