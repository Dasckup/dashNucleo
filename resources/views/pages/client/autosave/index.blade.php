@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('js')
    <script src="{{asset("/template/assets/js/datatables.js")}}"></script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Intensões de submissão</h1>
                            <span>Encontre detalhes importantes de autores que não terminram sua submissão.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body" style=" overflow: auto; ">
                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width:10%">Atendido</th>
                                        <th style="width:25%">Autor</th>
                                        <th style="width:25%">E-mail</th>
                                        <th style="width:25%">Celular</th>
                                        <th class="text-center" style="width:15%">Data e Hora</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                        <?php
                                            $name = mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8");
                                        ?>
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{route('client.intention.update', ['id'=>$client->id])}}" class="btn btn-success btn-style-light ps-3 pe-3" style="width:fit-content"><i style="font-size: 18px;" class="material-icons m-0">done</i></a>
                                                </td>
                                                <td>
                                                    {{$name != null? $name : "Não informado"}}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{$client->email != null? $client->email : "Não informado"}}
                                                        @if(preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $client->email))
                                                            <a class="d-flex align-items-center ms-1" style="text-decoration: none" href="mailto:{{$client->email}}">
                                                                <i style="font-size: 17px;" class="material-icons m-0">forward_to_inbox</i>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{$client->cellphone != null? $client->ddi." ".$client->cellphone : "Não informado"}}
                                                        @if(preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->cellphone))
                                                            <a target="_BLANK" class="d-flex align-items-center ms-1" style="text-decoration: none" href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $client->cellphone)?>?text=Ol%C3%A1+{{$name}}%2C+tudo+bem%3F">
                                                                <span style="font-size: 20px;" class="material-symbols-outlined m-0">
                                                                    quick_phrases
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">{{date("d/m/Y \á\s H:m", strtotime($client->created_at))}}</td>
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
    </div>
@endsection
