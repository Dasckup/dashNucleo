@extends('authors.main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
    input:disabled{
        background-color: #fff !important;
    }

    .proccess{
        min-width: 50px;
        min-height: 50px;
        border-radius: 50%;
        background-color: #E5E5E5;
        display: flex;
        justify-content: center;
        align-items: center;
        content: '';
    }

    .proccess:first-child::before{
        width: 0;
    }

    .proccess span{
        font-size: 30px;
        color: #999;
    }

    .proccess.active span{
        font-size: 30px;
        color: #fff;
    }

    .proccess.active{
        background-color: #0067ef;
    }

    .line-process{
        width: 100%;
        height: 5px;
        background-color: #E5E5E5;
        margin-bottom: 20px;
    }

    .proccess-list{
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
        align-items: center;
    }

    .proccess-line {
        width: 100%;
        height: 10px;
        background-color: #E5E5E5;
    }

    .proccess-line.active{
        background-color: #0067ef;
    }

    .material-right .material-items .sub-title-row-in-table{
        display: flex;
        justify-content: flex-end;
    }
    .material-right{
        flex-direction: row-reverse;
    }
    .label-value-clients{
        font-weight: 600;
        font-size: 11px!important
    }
    .value-clients{
        font-weight: 500;
        font-size: 12px!important
    }




    .events-list{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .events {
        display: flex;
        padding: 0px 0px 5px 0px;
    }

    .event-icon {
        margin-right: 10px;
        background: #fff;
        padding: 7px 7px 0px;
        border-radius: 100%;
        margin-left: -15px;
        height: fit-content;
    }

    .event-icon span{
        font-size: 17px;
        color: #696969;
    }




    .event-content{
        display: flex;
        flex-direction: column;
        position: relative;
        background: #fff;
        padding: 20px;
        border-radius: 4px;
        max-width: 500px;
    }

    .event-content-date{
        font-size: 11px;
        color: #666;
        margin-bottom: 5px;
    }

    .event-content-note{
        font-size: 12px;
        color: #696969;
        max-width: 380px;
        margin-bottom: 10px
    }

    .event-check {
        position: absolute;
        top: 0px;
        right: 0px;
        z-index: 100;
        margin-right: 0px;
        margin-top: 9px;
    }

    .event-content-material{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }



    .event-content-note.check{
        text-decoration: line-through;
    }







    .radio-container {
    display: block;
    position: relative;
    padding-left: 30px; /* Ajuste conforme necessário */
    margin-bottom: 15px;
    cursor: pointer;
    font-size: 16px;
    }

    .radio-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    }



    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border: 1px solid #dfdfdf;
        border-radius: 100%;
    }

    .radio-container:hover input ~ .checkmark {
    background-color: #ddd; /* Cor de fundo ao passar o mouse */
    }

    .radio-container input:checked ~ .checkmark {
        background-color: #00c866;
    }

    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }

    .radio-container input:checked ~ .checkmark:after {
    display: block;
    }

    .radio-container .checkmark:after {
        left: 6px;
        top: 3px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }


    .versions-material{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .versions-material-date {
        font-size: 12px;
        margin: 20px -15px;
        font-weight: 500;
        display: flex;
        color: #666;
    }

    .versions-material-line{
        height: auto;
        width: 1px;
        background: #cecece;
    }

    .version-icon-material{
        margin-right: 10px;
        margin-left: -9px;
        background: #fff;
        font-size: 20px;
        color: #cecece;
    }

    .event-line-icon-top {
        position: absolute;
        top: 0px;
        left: -8px;
        font-size: 19px;
        border-radius: 100%;
        color: #A6A6A6;
    }

    .event-line-icon-bottom {
        position: absolute;
        bottom: 0px;
        left: -8px;
        font-size: 19px;
        border-radius: 100%;
        color: #A6A6A6;
    }

    .events-line-background{
        background: #A6A6A6;
        height: 100%;
        width: 100%;
    }

    .events-line{
        height: auto;
        width: 3px;
        padding: 15px 0px 15px 0px;
        margin-top: 3px;
        margin-bottom: 11px;
    }

    .events-note{
        font-size: 12px;
        font-weight: 500;
        max-width: 515px;
        padding-left: 10px;
    }

    .events-date{
        font-weight: 600;
    }

    .event-date{
        font-size: 11px;
        font-weight: 500;
        color: #a9a6a6;
        margin-top: 10px;
    }

    .footer-event-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: -8px;
    }


    .coments-event-button {
        font-size: 11px;
        color: #999;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }

    .comments-event-button{
        margin-top: 13px;
        margin-left: -24px;
    }

    .coments-reponse-event-button,
    .coments-like-event-button,
    .coment-event-button{
        font-size: 11px;
        color: #999;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }

    .coments-like-event-button:hover,
    .coments-reponse-event-button:hover,
    .coment-event-button{
        color: var(--bs-primary);
    }

    .coments-event-button span{
        font-size: 14px;
        margin-left: 3px;
    }

    .coments-event-button:hover{
        color: #696969;
    }



    .event-comment{
        font-size: 12px;
        font-weight: 500;
        max-width: 456px;
        border-radius: 0px 10px 10px 10px!important;
    }

    .event-comment-icon-user{
        margin-right: 10px;
    }

    .event-comment-material-name{
        font-size: 11px;
        font-weight: 500;
    }
    .event-comment-material-size{
        font-size: 10px;
    }

    .event-not-comments{
        width: 100%;
        text-align: center;
        font-size: 11px;
        color: #999;
        margin-top: 20px;
    }

    .coment-event-button{
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        margin-top: 15px
    }

    .coment-event-button span{
        font-size: 14px;
    }

    .material-card{
        max-width: 395px;
    }

    .go-to-back-link{
        display: flex;
        text-decoration: none;
        font-weight: 600;
        font-size: 12px;
    }

    .material-title{
        font-size: 20px;
        font-weight: bold;
        margin-bottom: 3px;
    }



    .material-deadline{
        font-size: 12px;
        font-weight: 500;
    }

    .material-autor{
        font-size: 12px;
        font-weight: 500;
    }

    .material-file-title{
        font-size: 12px;
        font-weight: bold;
    }

    .material-file-size{
        font-size: 12px;
        font-weight: 500;
    }

    .material-file-displayed-title{
        font-size: 11px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .link-icon-to-material{
        color: #717171;
        margin-top: 0px;
        transition: color 0.3s ease-in-out;
    }

    .link-icon-to-material span{
        font-size: 20px;
    }

    .link-icon-to-material:hover{
        color: var(--bs-primary);
    }

    .avaliador-result{
        font-size: 12px;
        font-weight: 600;
    }

    .last-version-label{
        font-size: 11px;
        font-weight: 600;
        background: #fff;
        top: -8px;
        padding: 0px 6px;
        margin-left: 2px;
        color: #666;
    }

    .comment-report-icon{
        right: 0px;
        margin: -7px;
    }

    .comment-report-icon span{
        font-size: 20px;
        color: #999;
        transition: color 0.2s ease-in-out;
        cursor: pointer;
    }

    .comment-report-icon span:hover{
        color: var(--bs-danger);
    }

    .description-label-report {
        font-weight: 400;
        font-size: 10px;
        color: #999;
    }

    .modal-backdrop {
     z-index: 999999!important;
    }

    .modal {
        z-index: 9999999999!important;
    }

    .btn-close {
        background-size: 0.8em;
        box-shadow: none;
    }

    .label_radios_options_report{
        cursor: pointer;
    }

    .text-decoration-line-through{
        color: #999;
    }

    .date-of-comment{
        font-size: 11px;
        display: flex;
        align-items: center;
        color: #999;
    }
</style>
@endsection

@section('js')
<script src="{{asset("/template/assets/js/blockui.js")}}"></script>

<script>
    function showCommentsFrom(id){
        var ele = $('#comments-from-event-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function addCommentTo(id){
        var ele = $('#response-comment-to-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function reponseToComment(id){
        var ele = $('#list-response-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function addResponseTo(id){
        var ele = $('#response-comment-to-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function formatFileSize(size) {
        const kilobyte = 1024;
        const megabyte = kilobyte * 1024;

        if (size < kilobyte) {
            return size + ' B';
        } else if (size < megabyte) {
            return (size / kilobyte).toFixed(2) + ' KB';
        } else {
            return (size / megabyte).toFixed(2) + ' MB';
        }
    }

    $(document).ready(function (){
        $('form[name="comment"]').on('submit' , function (e) {
            e.preventDefault();

            var data = e.target;
            var id = $(this).attr('data-to');

            const commentText = data['comment-text'];
            const commentFile = data['comment-file'];
            const type = $(this).attr('data-type');

            if(commentText.value.trim().length===0){
                commentText.classList.add('is-invalid');
                commentText.focus();
                return;
            }else{
                commentText.classList.remove('is-invalid');
            }


            var formData = new FormData();
            formData.append('message', commentText.value);
            formData.append('to', id);
            formData.append('_token', '{{csrf_token()}}');

            if(commentFile.files[0]){
                if(commentFile.files[0].size > 10000000){
                    commentFile.classList.add('is-invalid');
                    commentFile.focus();
                    return;
                }else{
                    commentFile.classList.remove('is-invalid');
                }

                if(!(['application/pdf', 'application/docx']).includes(commentFile.files[0].type)){
                    commentFile.classList.add('is-invalid');
                    commentFile.focus();
                    return;
                }else{
                    commentFile.classList.remove('is-invalid');
                }

                formData.append('material', data['comment-file'].files[0]);
                formData.append('material_name', data['comment-file'].files[0].name);
                formData.append('material_size', formatFileSize(data['comment-file'].files[0].size)); //size aquis
                formData.append('material_extension', data['comment-file'].files[0].name.split('.').pop());
            }


            $('#response-comment-to-'+id).block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            $.ajax({
                url: '<?= route("AppAuthor.material.comment.store") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {

                    e.target.reset();
                    $('#response-comment-to-'+id).unblock();
                    $('#response-comment-to-'+id).slideToggle();

                    function getMaterialFileDisplay(){
                        if(data.material && data.material_url){
                            var material = data.material;
                            return `
                                <div class="d-flex flex-row justify-content-between mb-2 card p-2 align-items-center material-card">
                                    <div class="d-flex flex-row align-items-center">
                                        <div>
                                            <img width="25px" height="25px" src="http://127.0.0.1:8000/template/assets/images/icons/${material.extension}-icon.png">
                                        </div>
                                        <div class="ms-2 d-flex flex-column">
                                            <div class="text-black event-comment-material-name">${material.label}</div>
                                            <div class="event-comment-material-size">${material.size_material}</div>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="${data.material_url}">
                                            <span style="font-size:20px" class="material-symbols-outlined">download</span>
                                        </a>
                                    </div>
                                </div>
                            `;
                        }else{
                            return '';
                        }
                    }

                    function getFormNewComment(){
                        return `
                            <div class="d-flex mt-3">
                                <a onclick="reponseToComment('${data.comment.id}')" class="coments-reponse-event-button me-3 ">
                                    Respostas (0) <span class="material-symbols-outlined">expand_more</span>
                                </a>
                            </div>
                            <div style="display:none" id="list-response-${data.comment.id}">
                                <a onclick="addResponseTo('${data.comment.id}')" class="coment-event-button"><span class="material-symbols-outlined">add</span> Responder</a>
                                <div id="response-comment-to-${data.comment.id}" style="display:none">
                                    <div class="d-flex mb-4">
                                        <div class="h-100 event-comment-icon-user">
                                            <span class="material-symbols-outlined">
                                                account_circle
                                            </span>
                                        </div>
                                        <div class="w-100" style="max-width: 456px">
                                            <form name="comment" data-to="${data.comment.id}">
                                                <textarea style="border-radius: 0px 10px 10px 10px" name="" id="" cols="30" rows="3" class="form-control mb-2"></textarea>
                                                <input type="file" name="" id="" class="form-control mb-2">
                                                <div class="d-flex justify-content-end">
                                                    <button style="font-size: 11px;font-weight:600" type="submit" class="btn btn-primary p-2">comentar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    }

                    if(data.success){
                        var ele = $('#list-data-comments-'+id);
                        ele.html(`
                            <li class="d-flex flex-column">
                                <div class="d-flex">
                                    <div class="h-100 event-comment-icon-user">
                                        <span class="material-symbols-outlined text-primary">
                                            account_circle
                                        </span>
                                    </div>
                                    <div class="event-comment w-100 card p-3">
                                        <div class="mb-3">
                                            ${data.comment.message}
                                        </div>

                                    ${getMaterialFileDisplay()}
                                    ${type==="event"&&getFormNewComment()}

                                </div>
                            </div>
                        </li>
                        ${ele.html()}
                        `);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            })

        })


        $("form[name='send-form-report']").on('submit', (e) => {
            e.preventDefault();

            const data = e.target;

            if(data['report'].value.trim().length===0){
                showCustomToast("danger", {
                    title: "Algo deu errado...",
                    message: "Você precisa escolher um motivo para reportar o cometário.",
                });
                data['report'].classList.add('is-invalid');
                data['report'].focus();
                return;
            }

            if(data['term-of-responsibility-report'].checked===false){
                showCustomToast("danger", {
                    title: "Algo deu errado...",
                    message: "Você precisa aceitar os termos de responsabilidade para enviar o relatório.",
                });
                data['term-of-responsibility-report'].classList.add('is-invalid');
                return;
            }

            $(data).block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            $.ajax({
                url: '<?= route("AppAuthor.material.report.store" , ["process" => $process->id]) ?>',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'report': data['report'].value,
                    'to': data['to'].value,
                    'editor': '<?= auth()->id() ?>',
                    'author': data['editors'].value,
                },
                success: function (data) {
                    if(data.success){
                        showCustomToast("success", {
                            title: "Relatório enviado!",
                            message: "Recebemos seu relatório, em breve iremos analisar e tomar as devidas medidas.",
                        });
                        $(data).unblock();
                        $('#report-modal').modal('hide');
                    }
                },
                error: function (data) {
                    $(data).unblock();
                    $('#report-modal').modal('hide');

                    showCustomToast("danger", {
                        title: "Oppss algo deu errado...",
                        message: "Sentimos muito, mas não conseguimos enviar seu relatório, tente atualizar a pagina.",
                    });
                }
            })

        })

        $('#report-this-comment').on('click', function (e) {
            e.preventDefault();

            var id = $(this).attr('data-comment-id');
            var editors = $(this).attr('data-comment-editor');

            $('#report-modal').modal('show');
            $('#report-modal #to').val(id);
            $('#report-modal #editors').val(editors);
        })
    })

    function markAtConclusion(id){

        $("#event-"+id).block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        $.ajax({
                url: '<?= route("AppAuthor.material.comment.mark" , ["process" => $process->id]) ?>',
                type: 'POST',
                data: {
                    '_token': '{{csrf_token()}}',
                    'mark': id
                },
                success: function (data) {
                    $("#event-"+id).unblock();
                    if(data.success){
                        $('#mark-this-check-'+id).attr('disabled', true);
                        $('#mark-this-message-'+id).addClass('text-decoration-line-through');
                        $('#mark-this-label-'+id).addClass('text-decoration-line-through');
                    }else{
                        showCustomToast("danger", {
                            title: "Oppss algo deu errado...",
                            message: "Sentimos muito, mas não conseguimos enviar seu relatório, tente atualizar a pagina.",
                        });
                    }
                },
                error: function (data) {
                    $("#event-"+id).unblock();
                    showCustomToast("danger", {
                        title: "Oppss algo deu errado...",
                        message: "Sentimos muito, mas não conseguimos enviar seu relatório, tente atualizar a pagina.",
                    });
                }
            })

    }
</script>
@endsection


@section('content')

    <?php
        $extentions = explode('.', $process->material_content->url_material);
        $extention = end($extentions);

        $data = $process->analysis;

        $editorA = $process->verdict->editor_a;
        $editorB = $process->verdict->editor_b;

        $editors = [
            "$editorA" => [
                'type' => '1º Avaliador',
            ],
            "$editorB" => [
                'type' => '2º Avaliador',
            ],
        ];
    ?>


    @include('authors.pages.material.report.modal')

    <div class="app-content pt-5">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 mb-3">
                        <a class="go-to-back-link" href="{{route('AppAuthor.home')}}">
                            <span style=" font-size: 20px; " class="me-1 material-symbols-outlined">
                                arrow_back
                            </span>
                            Voltar a lista
                        </a>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="col-sm-12 pt-3">
                                    <div class="material-title mb-2 d-flex aling-items-center">
                                        Processo #{{$process->id}}
                                    </div>
                                    <div class="material-deadline mb-4">
                                        Prazo: <b class="{{determineDeadlineClass($process->deadline)}}"> 19 dias úteis ({{$process->deadline}})</b>
                                    </div>

                                    <span style=" font-size: 12px; font-weight: bold; ">
                                        Status:
                                    </span>

                                    <div class="d-flex align-items-center mb-1 mt-1 avaliador-result">
                                        1º Avaliador
                                        <?=
                                           getEditorAvaliableResult($process->verdict->result_editor_a);
                                        ?>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center avaliador-result">
                                        2º Avaliador
                                        <?=
                                           getEditorAvaliableResult($process->verdict->result_editor_b);
                                        ?>
                                    </div>


                                    <div class="d-flex position-relative mt-5 flex-row p-2 pt-3 card align-items-center justify-content-between">
                                        <span class="position-absolute last-version-label">Última versão</span>

                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/'.$process->material_content->file_last_version->extension.'-icon.png')}}">
                                            </div>
                                            <div>
                                                <div class="text-black material-file-title">{{$process->material_content->file_last_version->label}}</div>
                                                <div class="material-file-size">{{$process->material_content->file_last_version->size_material}}</div>
                                            </div>
                                        </div>
                                        <div class="material-file-download">
                                            <a class="material-file-download-icon" href="{{\App\Http\Middleware\AwsS3::getFile($process->material_content->file_last_version->url_material)}}">
                                                <span class="material-symbols-outlined">
                                                    download
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex ps-5 pt-0 card-body">
                        <div class="events-list">

                            @php
                                function groupByDate($array) {
                                    $result = [];
                                    foreach ($array as $item) {
                                        $date = date('Y-m-d', strtotime($item['created_at']));
                                        if(date('d/m/Y', strtotime($item['created_at']))==date('d/m/Y')){
                                            $date = 'Hoje';
                                        }

                                        $result[$date][] = $item;
                                    }
                                    return $result;
                                }

                                $groupedData = groupByDate($data);
                            @endphp

                            <div class="col-sm-12">

                            @foreach ($groupedData as $date => $group)
                                <div class="events">

                                    @if($date!=="Hoje")
                                        <div class="events-line position-relative">
                                            <span class="event-line-icon-top material-symbols-outlined">
                                                trip_origin
                                            </span>
                                            <div class="events-line-background"></div>
                                            <span class="event-line-icon-bottom material-symbols-outlined">
                                                trip_origin
                                            </span>
                                        </div>
                                    @endif

                                    <div class="d-flex flex-column" style="padding-left: 20px;">
                                        <div class="events-date mb-3"><?php echo $date === "Hoje" ? $date : \Carbon\Carbon::parse($date)->isoFormat('D ['.__('messages.datatable.of').'] MMMM ['.__('messages.datatable.of').'] YYYY') ?></div>
                                        @foreach ($group as $key => $item)
                                            <div class="card event-content card-body event" id="event-{{$item['id']}}">
                                                <div class="d-flex">
                                                    <div class="text-success" style=" padding-top: 5px;">
                                                        <span class="material-symbols-outlined">
                                                            for_you
                                                        </span>
                                                    </div>
                                                    <div class="events-note position-relative">
                                                        <a data-comment-editor="{{$item['editor']}}" data-comment-id="{{$item['id']}}" id="report-this-comment" style="margin: -12px;" class="position-absolute comment-report-icon">
                                                            <span class="material-symbols-outlined">
                                                                report
                                                            </span>
                                                        </a>
                                                        <div class="w-100" style=" font-size: 11px; font-weight: bold; ">
                                                            {{$editors[$item['editor']]['type']}}
                                                        </div>
                                                        <span class="<?php echo $item['check']?"text-decoration-line-through":""?>" id="mark-this-message-{{$item["id"]}}">{{ $item['message'] }}</span>
                                                    </div>
                                                </div>
                                                <div class="footer-event-content mt-3">
                                                    <div class="coments-event-footer">
                                                        <a onclick="showCommentsFrom('<?= $item['id'] ?>')" class="coments-event-button">
                                                            Comentarios ({{count($item["responses"])}})
                                                            <span class="material-symbols-outlined">expand_more</span>
                                                        </a>
                                                    </div>
                                                    <div class="event-date">
                                                        {{date('d/m/Y \á\s H:i', strtotime($item['created_at']))}}
                                                    </div>
                                                </div>

                                                <div style="display:none" class="event-comments" id="comments-from-event-{{$item['id']}}">
                                                    <a onclick="addCommentTo('<?= $item['id'] ?>')" class="coment-event-button"><span class="material-symbols-outlined">add</span> Adicionar Comentário</a>

                                                    <ul style="list-style:none;display:none" id="response-comment-to-{{$item["id"]}}" class="m-0 mb-5 p-0">
                                                        <li class="d-flex">
                                                            <div class="h-100 event-comment-icon-user">
                                                                <span class="material-symbols-outlined">
                                                                    account_circle
                                                                </span>
                                                            </div>
                                                            <div class="w-100" style="max-width: 456px">
                                                                <form data-type="event" name="comment" data-to="{{$item["id"]}}">
                                                                    <textarea style="border-radius: 0px 10px 10px 10px" name="comment-text" id="" cols="30" rows="3" class="form-control mb-2"></textarea>
                                                                    <input type="file" name="comment-file" id="" class="form-control mb-2 p-0 ps-2" style=" line-height: 37px; ">
                                                                    <div class="d-flex justify-content-end">
                                                                        <button style="font-size: 11px;font-weight:600" type="submit" class="btn btn-primary p-2">comentar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                    <ul style="list-style:none;" class="m-0 p-0">
                                                        <div id="list-data-comments-{{$item["id"]}}">
                                                            @if(count($item["responses"])>0)
                                                                @foreach ($item['responses'] as $comment)
                                                                    <li class="d-flex flex-column">
                                                                        <div class="d-flex">
                                                                            <div class="h-100 event-comment-icon-user">
                                                                                <span class="material-symbols-outlined {{!$comment["editor"]?"text-primary":"text-success"}}">
                                                                                    @if(!$comment["editor"]) account_circle @else for_you @endif
                                                                                </span>
                                                                            </div>
                                                                            <div class="event-comment w-100 card p-3">
                                                                                <div class="mb-3 position-relative">
                                                                                    @if($comment["editor"])
                                                                                        <div class="w-100" style=" font-size: 11px; font-weight: bold; ">
                                                                                            {{$editors[$item['editor']]['type']}}
                                                                                        </div>
                                                                                    @endif
                                                                                    {{$comment['message']}}
                                                                                </div>

                                                                                @if($comment["materials"])
                                                                                    @foreach ($comment["materials"] as $material)
                                                                                        <div class="d-flex flex-row justify-content-between mb-2 card p-2 align-items-center material-card" >
                                                                                            <div class="d-flex flex-row align-items-center">
                                                                                                <div>
                                                                                                    <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/'.$material['extension'].'-icon.png')}}">
                                                                                                </div>
                                                                                                <div class="ms-2 d-flex flex-column">
                                                                                                    <div class="text-black event-comment-material-name">{{$material['name']}}</div>
                                                                                                    <div class="event-comment-material-size">{{$material['size']}}</div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div>
                                                                                                <a href="{{\App\Http\Middleware\AwsS3::getFile($material['url'])}}">
                                                                                                    <span style="font-size:20px" class="material-symbols-outlined">download</span>
                                                                                                </a>
                                                                                            </div>
                                                                                        </div>
                                                                                    @endforeach
                                                                                @endif

                                                                                <div class="d-flex mt-3 flex-row aling-items-center justify-content-between">
                                                                                    <a onclick="reponseToComment('<?= $comment['id'] ?>')" class="coments-reponse-event-button me-3 ">
                                                                                        Respostas ({{count($comment["responses"])}}) <span class="material-symbols-outlined">expand_more</span>
                                                                                    </a>
                                                                                    <div class="date-of-comment">
                                                                                        {{date('d/m/Y \á\s H:i', strtotime($comment['created_at']))}}
                                                                                    </div>
                                                                                </div>

                                                                                <div style="display:none" id="list-response-{{$comment['id']}}">

                                                                                    <a onclick="addResponseTo('<?= $comment['id'] ?>')" class="coment-event-button"><span class="material-symbols-outlined">add</span> Responder</a>

                                                                                    <div id="response-comment-to-{{$comment['id']}}" style="display:none">
                                                                                        <div class="d-flex mb-4">
                                                                                            <div class="h-100 event-comment-icon-user">
                                                                                                <span class="material-symbols-outlined">
                                                                                                    account_circle
                                                                                                </span>
                                                                                            </div>
                                                                                            <div class="w-100" style="max-width: 456px">
                                                                                                <form name="comment" data-to="{{$comment["id"]}}">
                                                                                                    <textarea style="border-radius: 0px 10px 10px 10px" name="comment-text" id="" cols="30" rows="3" class="form-control mb-2"></textarea>
                                                                                                    <input type="file" name="comment-file" id="" class="form-control mb-2 p-0 ps-2" style=" line-height: 37px; ">
                                                                                                    <div class="d-flex justify-content-end">
                                                                                                        <button style="font-size: 11px;font-weight:600" type="submit" class="btn btn-primary p-2">comentar</button>
                                                                                                    </div>
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>



                                                                                    <div class="d-flex flex-column" id="list-data-comments-{{$comment["id"]}}">
                                                                                        @if(count($comment["responses"])>0)
                                                                                            @foreach ($comment['responses'] as $response)

                                                                                                <div class="d-flex">
                                                                                                    <div class="h-100 event-comment-icon-user">
                                                                                                        <span class="material-symbols-outlined {{!$response["editor"]?"text-primary":"text-success"}}">
                                                                                                            @if(!$response["editor"]) account_circle @else for_you @endif
                                                                                                        </span>
                                                                                                    </div>
                                                                                                    <div class="event-comment w-100 card p-3">
                                                                                                        <div class="mb-3 position-relative">
                                                                                                            @if($comment["editor"])
                                                                                                                <div class="w-100" style=" font-size: 11px; font-weight: bold; ">
                                                                                                                    {{$editors[$item['editor']]['type']}}
                                                                                                                </div>
                                                                                                            @endif
                                                                                                            {{$response['message']}}
                                                                                                        </div>

                                                                                                            @if($response["materials"])
                                                                                                                @foreach ($response["materials"] as $material)
                                                                                                                    <div class="d-flex flex-row justify-content-between mb-2 card p-2 align-items-center material-card" >
                                                                                                                        <div class="d-flex flex-row align-items-center">
                                                                                                                            <div>
                                                                                                                                <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/'.$material['extension'].'-icon.png')}}">
                                                                                                                            </div>
                                                                                                                            <div class="ms-2 d-flex flex-column">
                                                                                                                                <div class="text-black event-comment-material-name">{{$material['name']}}</div>
                                                                                                                                <div class="event-comment-material-size">{{$material['size']}}</div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                        <div>
                                                                                                                            <a href="{{\App\Http\Middleware\AwsS3::getFile($material['url'])}}">
                                                                                                                                <span style="font-size:20px" class="material-symbols-outlined">download</span>
                                                                                                                            </a>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                @endforeach
                                                                                                            @endif


                                                                                                            <div class="d-flex mt-3 flex-row aling-items-center justify-content-end">
                                                                                                                <div class="date-of-comment">
                                                                                                                    {{date('d/m/Y \á\s H:i', strtotime($comment['created_at']))}}
                                                                                                                </div>
                                                                                                            </div>
                                                                                                    </div>
                                                                                                </div>

                                                                                            @endforeach
                                                                                        @endif

                                                                                    </div>


                                                                                </div>
                                                                            </div>
                                                                        </div>


                                                                    </li>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@php

    function getEditorAvaliableResult($result){
        if($result===null){
            return '<span class="badge d-flex align-items-center badge-warning ms-2"><span style="font-size:12px" class="me-1 material-symbols-outlined"> schedule </span> Em analise</span>';
        }elseif($result === 1){
            return '<span class="badge d-flex align-items-center badge-success ms-2"><span style="font-size:12px" class="me-1 material-symbols-outlined"> done </span> Aprovado</span>';
        }elseif($result === 2){
            return '<span class="badge d-flex align-items-center badge-danger ms-2"><span style="font-size:12px" class="me-1 material-symbols-outlined"> block </span> Reprovado</span>';
        }
    }

    function determineDeadlineClass($deadlineDate)
    {
        $currentDate = now();
        $deadlineDate = new DateTime($deadlineDate);
        $currentDate = new DateTime($currentDate);
        $difference = $deadlineDate->diff($currentDate)->days;

        if ($difference < 0) {
            return 'text-danger';
        } elseif ($difference == 0) {
            return 'text-success';
        } elseif ($difference <= 2) {
            return 'text-warning';
        } else {
            return 'text-success';
        }
    }

@endphp
