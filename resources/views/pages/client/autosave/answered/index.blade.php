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
                                <a class="btn btn-danger button-table-header" href={{route("client.intention.index")}}>Autores não atendidos</a>

                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th class="text-center" style="width:15%">Atendido por</th>
                                        <th style="width:23%">Autor</th>
                                        <th style="width:25%">E-mail</th>
                                        <th style="width:17%">Celular</th>
                                        <th class="text-center" style="width:15%">Data e Hora</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $client)
                                        <?php
                                            $name = mb_convert_case($client->information->name, MB_CASE_TITLE, "UTF-8");
                                        ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <a data-bs-toggle="modal" data-bs-target="#<?=$client->information->id?>" class="btn btn-info btn-style-light ps-2 pe-2" style="width:fit-content">
                                                                <i style="font-size: 23px;" class="material-icons m-0">info</i>
                                                            </a>
                                                        </div>
                                                        <div>
                                                            {{$client->users->name}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{$name != null? $name : "Não informado"}}
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{$client->information->email != null? $client->information->email : "Não informado"}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        {{$client->information->cellphone != null? $client->information->ddi." ".$client->information->cellphone : "Não informado"}}
                                                    </div>
                                                </td>
                                                <td class="text-center">{{date("d/m/Y \á\s H:m", strtotime($client->information->created_at))}}</td>
                                            </tr>


                                            <div class="modal fade" id="<?=$client->information->id?>" tabindex="-1" aria-labelledby="<?=$client->information->id?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Justificativa:</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: 12px;font-weight:500">
                                                               {{date("d/m/Y \á\s H:m", strtotime($client->information->created_at))}} até {{date("d/m/Y \á\s H:m", strtotime($client->created_at))}}
                                                                <br />
                                                                <br/>
                                                                {{$client->observation}}
                                                                <br />
                                                                <br />
                                                                Por: <b>{{$client->users->name}}</b>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>




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
