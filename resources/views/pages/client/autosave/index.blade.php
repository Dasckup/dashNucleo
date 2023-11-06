@extends('main._index')

@section('css')
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
                                <a class="btn btn-success button-table-header" href={{route("client.intention.show")}}>Autores atendidos</a>

                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="display:none">id</th>
                                            <th class="text-center" style="width:10%">Atendido</th>
                                            <th style="width:25%">Autor</th>
                                            <th style="width:25%">E-mail</th>
                                            <th style="width:25%">Celular</th>
                                            <th class="text-center" style="width:15%">Data e Hora</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($clients as $key => $client)
                                            <?php
                                                $name = mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8");
                                            ?>
                                            <tr>
                                                <td style="display:none">
                                                    <?= $key ?>
                                                </td>
                                                <td class="text-center">
                                                    <a data-bs-toggle="modal" data-bs-target="#<?=$client->id?>" class="btn btn-success btn-style-light ps-3 pe-3" style="width:fit-content"><i style="font-size: 18px;" class="material-icons m-0">done</i></a>
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
                                                            <a target="_BLANK" class="d-flex align-items-center ms-1" style="text-decoration: none" href="https://wa.me/<?= str_replace('+', '',$client->ddi)?><?= preg_replace('/[^0-9]/', '', $client->cellphone)?>?text=Ol%C3%A1+{{$name}}%2C+tudo+bem%3F">
                                                                <span style="font-size: 20px;" class="material-symbols-outlined m-0">
                                                                    quick_phrases
                                                                </span>
                                                            </a>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-center">{{date("d/m/Y \á\s H:m", strtotime($client->created_at))}}</td>
                                            </tr>
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
