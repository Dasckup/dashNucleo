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
                            <h1>Submissões <span class="text-lowercase text-<?= $status["bg"] ?>"><?=$status["title"]?></span></h1>
                            <span>Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="width:0%;" class="text-center d-none">#</th>
                                        <th style="width:4%" class="text-center">Status</th>
                                        <th style="width:25%">Submissor</th>
                                        <th style="width:19%">Produto/Prazo</th>
                                        <th style="width:25%">Contato</th>
                                        <th style="width:15%" >data de submissão</th>
                                        <th style="width:13%" class="text-center">Ações</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $reponse)
                                            <?php
                                              $client = $reponse->clients;
                                              $name = mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8");
                                              $email = $client->email != null? $client->email : "Não informado";
                                            ?>
                                        <tr>
                                            <td class="d-none">{{$client->id}}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a style=" font-size: 13px; text-transform: uppercase;font-weight: 600" class="btn border-2 bg-transparent  text-@if($client->status){{$client->status->bs}}@endif border-@if($client->status){{$client->status->bs}}@endif dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if($client->status){{$client->status->status}}@endif
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li><a class="dropdown-item d-flex align-items-center text-warning" href="{{route("client.update", ["id"=>$client->id,"status"=>"pendente"])}}">
                                                        <i class="material-icons me-2" style="font-size: 19px">schedule</i> Pendente
                                                        </a></li>
                                                        <li><a class="dropdown-item d-flex align-items-center text-info" href="{{route("client.update", ["id"=>$client->id,"status"=>"atendido"])}}">
                                                        <i class="material-icons me-2" style="font-size: 19px">done</i> Atendido
                                                        </a></li>
                                                        <li><a class="dropdown-item d-flex align-items-center text-success" href="{{route("client.update", ["id"=>$client->id,"status"=>"pago"])}}">
                                                        <i class="material-icons me-2" style="font-size: 19px">attach_money</i> Pago
                                                        </a></li>
                                                        <li><a class="dropdown-item d-flex text-danger align-items-center" href="{{route("client.update", ["id"=>$client->id,"status"=>"cancelado"])}}">
                                                        <i class="material-icons me-2" style="font-size: 19px">close</i> Cancelado
                                                        </a></li>
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
                                                </div>
                                            </td>
                                            <td>
                                                @if($client->submission)
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">
                                                            {{$client->submission->term_publication_title}}
                                                        </p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                            @if(!str_contains($client->submission->term_publication_price,"BRL"))
                                                                <i title="internacional" class="material-icons text-gray" style=" font-size: 16px; margin-right:4px">public</i>
                                                            @endif
                                                            {{$client->submission->term_publication_price}}
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
                                            <td class="">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">{{date("d/m/Y", strtotime($client->created_at))}}</p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">{{date("\á\s H:i", strtotime($client->created_at))}}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{route("client.show", ["id"=>$client->id])}}">VER MAIS</a>
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
    </div>
@endsection
