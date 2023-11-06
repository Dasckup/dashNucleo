@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="{{asset("/template/assets/app/css/autosave/style.css")}}" />

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

<?php
    $typesContact = App\Http\Middleware\TypesContact::get();
?>

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
                                <a class="btn btn-success button-table-header" href={{route("client.intention.show")}}>Atendimentos finalizados</a>

                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="d-none">id</th>
                                            <th class="text-center" style="width:10%">Atendimento</th>
                                            <th style="width:33%">Autor</th>
                                            <th style="width:33%">E-mail</th>
                                            <th class="text-center" style="width:8%">Finalizar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $key => $client)
                                            <?php
                                                $name = mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8");
                                                $email = $client->email != null? $client->email : "Não informado";
                                            ?>
                                            <tr>
                                                <td class="d-none">
                                                    <?= $key ?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3 options-contact">
                                                            <a data-bs-toggle="modal" data-bs-target="#add-contact-<?=$client->id?>" class="add-contact">
                                                                <i class="material-icons">add_circle</i>
                                                            </a>
                                                            <a data-bs-toggle="modal" data-bs-target="#history-contact-<?=$client->id?>" class="view-history">
                                                                <i class="material-icons">history</i>
                                                            </a>
                                                        </div>

                                                        <div class="d-flex align-items-center">
                                                            <div class="d-flex align-items-center">
                                                                <div>
                                                                    <p class="m-0 title-row-in-table text-{{(count($client->contacts)<7)?"danger":"success"}} number-contact"><?=count($client->contacts)?></p>
                                                                    <p style="font-weight:500" class="m-0 sub-title-row-in-table">Contatos</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?=CreateRow($name != null? $name : "Não informado",date("d/m/Y \á\s H:m", strtotime($client->created_at)))?>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
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
                                                                    {{$email}}
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
                                                                    {{$client->cellphone != null? $client->ddi." ".$client->cellphone : "Não informado"}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <a data-bs-toggle="modal" data-bs-target="#<?=$client->id?>" class="btn btn-success btn-style-light ps-3 pe-3" style="width:fit-content"><i style="font-size: 18px;" class="material-icons m-0">done</i></a>
                                                </td>
                                            </tr>








                                            <div class="modal fade" id="add-contact-<?=$client->id?>" tabindex="-1" aria-labelledby="add-contact-<?=$client->id?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Salvar contato</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: 12px;">
                                                                <span style="font-weight:500">Deseja salvar {{(count($client->contacts)==0)?"seu primeiro":"o ".(count($client->contacts)+1)."º"}} contato feito com </span> <b>{{$name}}</b> ?</span>
                                                            </p>
                                                            <div>
                                                                <form action="{{route('client.intention.update.contact', ['id'=>$client->id])}}" method="POST">
                                                                    @csrf
                                                                    <textarea placeholder="Observação" name="obs" class="form-control mb-3" id="obs" cols="30" rows="10"></textarea>
                                                                    <input required type="datetime-local" name="date" class="form-control mb-3" id="date">
                                                                    <select style="font-size:12px" required name="type_contact" id="type_contact" class="form-select mb-3">
                                                                        <option value="">Selecione</option>
                                                                        @foreach ($typesContact as $type)
                                                                            <option value="{{$type->id}}">{{$type->label}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <button style="font-size: 12px;font-weight:500" type="submit" class="btn btn-success w-100">Salvar contato</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>













                                            <div class="modal fade" id="history-contact-<?=$client->id?>" tabindex="-1" aria-labelledby="history-contact-<?=$client->id?>" aria-hidden="true">
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


















                                            <div class="modal fade" id="<?=$client->id?>" tabindex="-1" aria-labelledby="<?=$client->id?>" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Marcar autor como Atendido</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p style="font-size: 12px;">
                                                                <span style="font-weight:500">Deseja marcar o autor(a)</span> <b>{{$name}}</b> <span style="font-weight:500">como atendido?</span>
                                                            </p>
                                                            <p style="font-size: 12px;font-weight:500">
                                                                Após marcar o autor como atendido, você afirmar ter entrado em contato com o mesmo. Caso não tenha entrado em contato, o autor poderá reclamar sobre o atendimento.
                                                            </p>
                                                            <div>
                                                                <form action="{{route('client.intention.update', ['id'=>$client->id])}}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="id" value="{{$client->id}}">
                                                                    <textarea required placeholder="Escreva sua justificativa..." name="justification" class="form-control mb-3" id="justification" cols="30" rows="10"></textarea>
                                                                    <button style="font-size: 12px;font-weight:500" type="submit" class="btn btn-success w-100">Marcar como atendido</button>
                                                                </form>
                                                            </div>
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
