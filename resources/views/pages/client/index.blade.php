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
    .text-red-light {
        color: #e3504b!important;
    }
    .border-red-light{
        border-color: #e3504b!important;
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

    <script>

        async function statusUpdate(element){
            $('#blockui-card-1').block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            const status = element.target.getAttribute('data-value');
            const client = element.target.getAttribute('data-to');

            if(status == "pagamento_pendente" || status == "pago"){

                const result = await $.ajax({
                    url: "{{route('client.consult.term')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user": "{{Auth::user()->id}}",
                        "id": client
                    },
                });

                if(result.success==true){
                    if(result.client.term == false){
                        $('#blockui-card-1').unblock();
                        $('#SelecionarPrazo').modal('show');
                        $("form[name='formNewPrazo'] #client").val(client);
                        $("form[name='formNewPrazo'] #status").val(status);
                        $('#author-name-prazo').html(result.client.name);
                        return;
                    }
                }else{
                    return false;
                }
            }

            $.ajax({
                url: "{{route('client.update.status')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user": "{{Auth::user()->id}}",
                    "status": status,
                    "id": client
                },
                success: (data) => {
                    $("#client-"+client).remove();
                    showCustomToast("success", {
                        title: "Status da submissão atualizado com sucesso",
                        message: `A submissão foi movida para aba de submissões ${data.status.status}`,
                    });
                    $('#blockui-card-1').unblock();
                },
                error: (data) => {
                    showCustomToast("danger", {
                        title: "Erro ao atualizar status da submissão",
                        message: `A submissão não foi movida para aba de submissões ${data.status.status}`,
                    });
                    $('#blockui-card-1').unblock();
                }
            })
        }


        $(".dropdown-item-select-status-client").on("click" , function (event) {
            statusUpdate(event);
        })


        $("form[name='formNewPrazo']").on('submit', function (e) {
           e.preventDefault();

            $('#SelecionarPrazo').block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            const status = e.target.status.value;
            const client = e.target.client.value;
            const term = e.target.prazo.value;
            const currency = e.target.currency.value;

            $.ajax({
                url: "{{route('client.update.submission')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user": "{{Auth::user()->id}}",
                    "status": status,
                    "id": client,
                    "term": term,
                    "currency": currency
                },
                success: (data) => {
                    $("#client-"+client).remove();
                    showCustomToast("success", {
                        title: "Status da submissão atualizado com sucesso",
                        message: `A submissão foi movida para aba de submissões ${data.status}`,
                    });
                    $('#SelecionarPrazo').unblock();
                    $('#SelecionarPrazo').modal('hide');
                },
                error: (data) => {
                    showCustomToast("danger", {
                        title: "Erro ao atualizar status da submissão",
                        message: `A submissão não foi movida`,
                    });
                    $('#SelecionarPrazo').unblock();
                }
            })
        })
    </script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">

            <div class="modal fade" id="SelecionarPrazo" tabindex="-1" aria-labelledby="SelecionarPrazo" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5>Selecione o Prazo</h5>
                            <p>O autor <b id="author-name-prazo"></b> ainda não contem um prazo, selecione um prazo para continuar</p>
                            <form name="formNewPrazo">
                                <input type="hidden" id="client" name="client" value="" />
                                <input type="hidden" id="status" name="status" value="" />
                                <div class="row">
                                    <div class="mb-3 col-sm-8">
                                        <label for="prazo" class="form-label">Prazo <code>*</code></label>
                                        <select class="form-select" id="prazo" name="prazo">
                                            {!! App\Models\Products::get()->map(function($item){
                                                return "<option value='{$item->id}'>{$item->title}</option>";
                                            })->implode("") !!}
                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-4">
                                        <label for="currency" class="form-label">Moeda <code>*</code></label>
                                        <select class="form-select" id="currency" name="currency">
                                            <option value="BRL">Real</option>
                                            <option value="USD">Dolar</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Continuar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


                <div class="row">
                    <div class="col">
                        <div class="page-description pt-2 ps-0 pb-0 border-0">
                            <h1>Submissões <span class="text-lowercase text-<?= $status["bg"] ?>"><?=$status["title"]?></span></span></h1>
                            <span style="margin-top: 10px;">Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="display-alert" class="col-sm-12">
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
                                            <th style="width:4%" class="text-center">Status</th>
                                            <th style="width:25%">Autor</th>
                                            <th style="width:19%">Prazo</th>
                                            <th style="width:25%">Contatos</th>
                                            <th style="width:15%" >Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $reponse)
                                            <?php
                                              $client = $reponse->material->clients;
                                              $name = explode(' ', mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8"))[0];
                                              $email = $client->email != null? $client->email : "Não informado";
                                            ?>
                                        <tr id="client-{{$reponse->material->id}}">
                                            <td class="text-center" >
                                                <div style="height:39px!important" class="d-flex align-items-center justify-content-center">
                                                    {{$reponse->material->id}}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a style=" font-size: 13px; text-transform: uppercase;font-weight: 600" class="btn border-2 bg-transparent  text-@if($client->status){{$client->status->bs}}@endif border-@if($client->status){{$client->status->bs}}@endif dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if($client->status){{$client->status->status}}@endif
                                                    </a>
                                                    @php
                                                        $routsStatus = [
                                                            'pendente' => [
                                                                'color' => 'warning',
                                                                'title' => 'Pendente',
                                                                'icon' => 'ring_volume'
                                                            ],
                                                            'pendencias' => [
                                                                'color' => 'red-light',
                                                                'title' => 'Pendencias',
                                                                'icon' => 'error'
                                                            ],
                                                            'atendido' => [
                                                                'color' => 'primary',
                                                                'title' => 'Em atendimento',
                                                                'icon' => 'phone_callback'
                                                            ],
                                                            'aceito' => [
                                                                'color' => 'info',
                                                                'title' => 'Aceito',
                                                                'icon' => 'verified'
                                                            ],
                                                            'recusado' => [
                                                                'color' => 'danger',
                                                                'title' => 'Recusado',
                                                                'icon' => 'content_paste_off'
                                                            ],
                                                            'pagamento_pendente' => [
                                                                'color' => 'pink',
                                                                'title' => 'Pagamento pendente',
                                                                'icon' => 'currency_exchange'
                                                            ],
                                                            'pago' => [
                                                                'color' => 'success',
                                                                'title' => 'Pago',
                                                                'icon' => 'paid'
                                                            ],
                                                            'cancelado' => [
                                                                'color' => 'gray',
                                                                'title' => 'Cancelado',
                                                                'icon' => 'cancel'
                                                            ]
                                                        ];
                                                    @endphp

                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @foreach($routsStatus as $status => $details)
                                                            <li>
                                                                <a  class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center text-{{ $details['color'] }}" style="" data-value="{{ $status }}" data-to="{{ $reponse->material->id }}">
                                                                    <i class="material-icons me-2" style="font-size: 19px">{{ $details['icon'] }}</i> {{ $details['title'] }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0  text-black title-row-in-table">{{$client->name}} {{$client->last_name}}</p>
                                                        @if($client->submission->find_us!=="outro")
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">@if(isset($client->submission)){{$client->submission->find_us}}@endif</p>
                                                        @else
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">@if(isset($client->submission)){{$client->submission->outer_find_us}}@endif</p>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <a class="link-to-open-submition" href="{{route("client.show", ["id"=>$reponse->material->id])}}">
                                                            <i class="material-symbols-outlined text-gray" >bubble</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($client->submission->term_publication_title)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">
                                                            {{$client->submission->term_publication_title}}
                                                        </p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                            @if(!str_contains($client->submission->term_publication_price,"BRL"))
                                                                <i title="internacional" class="material-icons text-gray" style=" font-size: 16px; margin-right:4px">public</i>
                                                            @endif
                                                            @if(preg_replace('/[^a-zA-Z]/', '', $client->submission->term_publication_price))
                                                                @php
                                                                    $amount = preg_replace('/[^\d.,]/', '', $client->submission->term_publication_price);
                                                                    $currencyCode = preg_replace('/[^a-zA-Z]/', '', $client->submission->term_publication_price);
                                                                @endphp
                                                                {{formatCurrency($amount, $currencyCode)}}
                                                            @else
                                                                {{$client->submission->term_publication_price}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                @else
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">
                                                            Nenhum prazo definido
                                                        </p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                           0.00
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table d-flex">
                                                            @if(preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $client->email))
                                                                <a  class="d-flex align-items-center me-2" style="text-decoration: none" href="mailto:{{$client->email}}">
                                                                    <i style="font-size: 15px;" class="material-icons m-0">forward_to_inbox</i>
                                                                </a>
                                                            @else
                                                                <a class="d-flex align-items-center text-grey me-2" style="text-decoration: none;color:#b3b3b3">
                                                                    <i style="font-size: 15px;" class="material-icons m-0">forward_to_inbox</i>
                                                                </a>
                                                            @endif
                                                            <span>{{$client->email}}</span>
                                                        </p>


                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex">
                                                            @if(preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->cellphone))
                                                                <a target="_BLANK" class="d-flex align-items-center me-1" style="text-decoration: none" href="https://wa.me/<?= str_replace('+', '',$client->ddi)?><?= preg_replace('/[^0-9]/', '', $client->cellphone)?>?text=Ol%C3%A1+{{$name}}%2C+tudo+bem%3F">
                                                                    <span style="font-size: 15px;" class="material-symbols-outlined m-0">
                                                                        quick_phrases
                                                                    </span>
                                                                </a>
                                                            @else
                                                                <a class="d-flex align-items-center text-grey me-2" style="text-decoration: none;color:#b3b3b3">
                                                                    <span style="font-size: 15px;" class="material-symbols-outlined m-0 ">
                                                                        quick_phrases
                                                                    </span>
                                                                </a>
                                                            @endif
                                                            <span>{{$client->ddi}} {{$client->cellphone}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">{{date("d/m/Y", strtotime($client->created_at))}}</p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">{{date("\á\s H:i", strtotime($client->created_at))}}</p>
                                                    </div>
                                                </div>
                                            </td>
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


