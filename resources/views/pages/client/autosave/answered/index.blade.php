    @extends('main._index')

    @section('css')
    <link rel="stylesheet" href="{{asset("/template/assets/app/css/autosave/style.css")}}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .button-table-header{
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
        margin-bottom: 17px;
    }

    .btn-close {
        background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/10px auto no-repeat;
    }

    </style>
    @endsection

    @section('js')
        <script src="{{asset("/template/assets/js/datatables.js")}}"></script>
    @endsection

    @section('content')
        <div class="app-content">
            <div class="content-wrapper">
                <div class="">
                    <div class="row">
                        <div class="col">
                            <div class="page-description pt-2 ps-0 pb-0 border-0">
                                <h1>Intensões de submissão</h1>
                                <span style="margin-top: 10px;">Encontre detalhes importantes de autores que não terminram sua submissão.</span>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card">
                                <div class="card-body" style=" overflow: auto; ">
                                    <a class="btn btn-danger button-table-header" href={{route("client.intention.index")}}>Atendimentos não finalizados</a>

                                    <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th class="d-none">id</th>
                                            <th class="text-center" style="width:15%">Atendido por</th>
                                            <th style="width:25%">Autor</th>
                                            <th style="width:25%">E-mail</th>
                                            <th class="text-center" style="width:10%">Contatos</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($clients as $key => $client)
                                                <?php
                                                    $name = mb_convert_case($client->information->name, MB_CASE_TITLE, "UTF-8");
                                                    $email = $client->information->email != null? $client->information->email : "Não informado";
                                                    $celular = $client->information->cellphone != null? $client->information->ddi." ".$client->information->cellphone : "Não informado";
                                                ?>
                                                <tr>
                                                    <td class="d-none">
                                                        <?= $key ?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3">
                                                                <a data-bs-toggle="modal" data-bs-target="#<?=$client->information->id?>" class="btn btn-info btn-style-light ps-2 pe-2" style="width:fit-content">
                                                                    <i style="font-size: 23px;" class="material-icons m-0">info</i>
                                                                </a>
                                                            </div>
                                                            <?=CreateRow($client->users->name,date("d/m/Y \á\s H:m", strtotime($client->created_at)))?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <?=CreateRow($name != null? $name : "Não informado",date("d/m/Y \á\s H:m", strtotime($client->information->created_at)))?>
                                                    </td>
                                                    <td>
                                                        <?=CreateRow($email,$celular)?>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="me-3 options-contact">
                                                                <a data-bs-toggle="modal" data-bs-target="#history-contact-<?=$client->information->id?>" class="view-history">
                                                                    <i class="material-icons">history</i>
                                                                </a>
                                                            </div>

                                                            <div class="d-flex align-items-center">
                                                                <div class="d-flex align-items-center">
                                                                    <div>
                                                                        <p class="m-0 title-row-in-table text-black number-contact"><?=count($client->contacts)?></p>
                                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">Contatos</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
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
                                                                    <br />
                                                                    Foram nescessário <b>{{count($client->contacts)}} contatos</b>
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



                                                <div class="modal fade" id="history-contact-<?=$client->information->id?>" tabindex="-1" aria-labelledby="history-contact-<?=$client->information->id?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Historico de contato</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p style="font-size: 12px;">
                                                                    <span style="font-weight:500">Esses são os todos os contatos feito com </span> <b>{{$name}}</b></span>
                                                                </p>

                                                                    @if(count($client->contacts)==0)
                                                                        <div class="w-100">
                                                                            <div class="contact-notFound">
                                                                                Nenhum contato feito <b class="ms-1">{{$name}}</b>
                                                                            </div>
                                                                        </div>
                                                                    @else

                                                                    <div class="w-100 d-flex flex-row position-relative" style="min-height: 150px">
                                                                        <div class="bar-timeline"></div>
                                                                        <div class="timeline">
                                                                            <ul class="timeline-list">
                                                                                @foreach ($client->contacts as $contact)
                                                                                    <li class="timeline-list-item">
                                                                                        <p class="timeline-list-item-obs">{{$contact->observation}}</p>
                                                                                        <div class="d-flex w-100 justify-content-between">
                                                                                            <div>{{$contact->users->name}}</div>
                                                                                            <div>{{date("d/m/Y \á\s H:i", strtotime($contact->date))}}</div>
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    @endif

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

    <?php

    function CreateRow($data1,$data2){
        return (
            '
            <div class="d-flex align-items-center">
                <div class="d-flex align-items-center">
                    <div>
                        <p class="m-0 text-black title-row-in-table">'.$data1.'</p>
                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">'.$data2.'</p>
                    </div>
                </div>
            </div>
            '
        );
    }
    ?>
