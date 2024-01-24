@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
    .dropdown-item{
        cursor: pointer;
    }

    .alert-custom{
        margin-bottom: 15px;
    }

    .text-pink {
        color: var(--bs-pink)!important;
    }
    .border-pink{
        border-color: var(--bs-pink)!important;
    }

    .text-gray {
        color: var(--bs-gray)!important;
    }
    .border-gray{
        border-color: var(--bs-gray)!important;
    }
    .link-to-open-submition i{
        font-size: 25px;
        margin-left: 12px;
    }
</style>
@endsection

@section('js')
    <script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
    <script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper container">


                <div class="row">
                    <div class="col">
                        <div class="page-description pt-2 ps-0 pb-0 border-0">
                            <h1>Produtos</h1>
                            <span style="margin-top: 10px;">Encontre detalhes importantes, sobre os produtos, de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div id="blockui-card-1" class="card-body">
                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:4%;" class="text-center">#</th>
                                            <th style="width:75%">Produto</th>
                                            <th style="width:15%" >Criado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            <tr>
                                                <td class="text-center" >
                                                    <div style="height:39px!important" class="d-flex align-items-center justify-content-center">
                                                        {{$product->id}}
                                                    </div>
                                                </td>
                                                <td>{{$product->name}}</td>
                                                <td>{{$product->created_at->format('d/m/Y')}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>

    @php

        function formatCurrency($amount, $currencyCode) {
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
    @endphp

@endsection


