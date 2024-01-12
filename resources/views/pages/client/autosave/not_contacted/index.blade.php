@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<link rel="stylesheet" href="{{custom_asset("/template/assets/app/css/autosave/style.css")}}" />
<style>
.spinner-border {
    border-right-color: transparent!important;
    width: 1.2rem!important;
    height: 1.2rem!important;
    margin-right: 10px!important;
}
.checkMessageSendedIcon{
    font-size: 17px;
    margin-top: 0px;
}
</style>
@endsection

@section('js')
<script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>

<script>
    function sendMessage() {
        const el = $("td.sendTo");

        if (el.length === 0) {
            return;
        }

        const numbers = [];
        el.each(function () {


            const cellphone = $(this).text().replace(/\D/g, '');

            let client = {
                el: $(this),
                name: $(this).parent().find("td:first-child").text(),
                number: cellphone,
                token: $(this).parent().find("td.token input").val(),
                id: $(this).parent().find("td.id").text()
            };

            $(this).parent().find("td:first-child").html(`
                <div class="d-flex align-items-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    ${client.name}
                </div>
            `);

            numbers.push(client);
        });

        function sendWithDelay(index) {
            const element = numbers[index];

            if (index < numbers.length) {
                    setTimeout(() => {
                    $.ajax({
                            url: "{{route('client.intention.not_contacted.send_message')}}",
                            type: "POST",
                            headers: {
                                'X-CSRF-TOKEN': element.token
                            },
                            data: {
                                client: element.id,
                                name: element.name,
                                cellphone: element.number,
                                user: "{{Auth::user()->id}}"
                            },
                            success: function (data) {
                                sendWithDelay(index + 1);
                                element.el.parent().find("td:first-child").html(`
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center" style="margin-right:10px">
                                            <i class="material-icons checkMessageSendedIcon text-success">check</i>
                                        </div>
                                        ${element.name}
                                    </div>
                                `);
                            },
                            error: function (data) {
                                sendWithDelay(index + 1);
                                element.el.parent().find("td:first-child").html(`
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex align-items-center" style="margin-right:10px">
                                            <i class="material-icons checkMessageSendedIcon text-danger">close</i>
                                        </div>
                                        ${element.name}
                                    </div>
                                `);
                            }
                        });
                }, 1000);
            }else{
                $("#send-message-for-all").modal("hide");
                document.location.reload(true);
            }
        }
        sendWithDelay(0);
    }
</script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Enviar Mensagem</h1>
                            <span>Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="card">
                        <div class="card-body" style=" overflow: auto; ">
                            <div class="mb-4 col-sm-12">
                                <a data-bs-toggle="modal" data-bs-target="#send-message-for-all" class="btn btn-success button-table-header" style="font-size:12px;font-weight:600">Enviar mensagem para todos</a>
                            </div>

                            <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="d-none">id</th>
                                        <th class="text-center" style="width:50%">Autores</th>
                                        <th class="text-center" style="width:40%">Contato</th>
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
                                                <?=
                                                    $key
                                                ?>
                                            </td>
                                            <td>
                                                <?=
                                                    CreateRow(
                                                        $name != null? $name : "Não informado",
                                                        date("d/m/Y \á\s H:m", strtotime($client->created_at))
                                                    )
                                                ?>
                                            </td>
                                            <td>
                                                <?=
                                                    CreateRow(
                                                        $email,
                                                        ($client->cellphone != null? $client->ddi." ".$client->cellphone : "Não informado")
                                                    )
                                                ?>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>




                            <div class="modal fade" id="send-message-for-all" tabindex="-1" aria-labelledby="send-message-for-all" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Enviar mensagem para todos</h5>
                                            <button  type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p style="font-size: 12px;">
                                                <b>Atenção!</b> <span style="font-weight:500"> Você tem certeza que deseja enviar mensagem via Whatsapp para todos os autores , com número de celular valido, não atendidos?</span>
                                            </p>
                                            <p style="font-size: 12px;font-weight:500">
                                                <b>Obs:</b> <span style="font-weight:500"> As mensagens serão enviadas em seu nome e essa ação não poderá ser desfeita</span>
                                            </p>
                                            <p>
                                                <button onclick="sendMessage()" style="font-size: 12px;font-weight:500" class="btn btn-success w-100">ENVIAR MENSAGEM</button>
                                            </p>
                                            <div class="w-100" style="overflow:auto;max-height: 400px;">
                                                <table class="display table align-middle  table-bordered border-primary" style="width:100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Celular</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($clients as $key => $client)
                                                            @if(preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->cellphone)&&$client->name != null)
                                                                <tr class="mb-2">
                                                                    <td style="font-size:12px;font-weight:600">{{$client->name}}</td>
                                                                    <td style="font-size:12px;font-weight:600" class="sendTo"><?= $client->ddi." ".$client->cellphone ?></td>
                                                                    <td class="token d-none" class="d-none">@csrf</td>
                                                                    <td class="id d-none">{{$client->id}}</td>
                                                                </tr>
                                                            @endif
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
