@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
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
    .events {
        display: flex;
        padding: 0px 0px 5px 0px;
    }

    .file-card{
        margin-left: -2px;
        border: 1px solid #e7e7e7;
        box-shadow: none;
    }
    .photo-client-card{
        margin-left: -2px;
        border: 1px solid #e7e7e7;
        box-shadow: none;
        border-radius: 6px;
    }
    .events-date{
        font-weight: 500;
        font-size: 12px;
        color: #666;
    }
    .button-add-file{
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
        margin-bottom: 25px;
    }

    .button-add-note{
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
        margin-bottom: 25px;
    }

    .file-item-title{
        max-width: 340px;
        font-weight: 600!important;
        min-width: 339px;
        font-size: 12px!important;
    }


    #fileInput {
      display: none;
    }
    #fileDrop {
        padding: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e7ecf8;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #535353;
        border: 3px dashed transparent;
        transition: all 0.3s ease;
    }

    #fileDrop:hover,
    #fileDrop.dragover {
      border-color: #ced5e1;
    }

    .title-form-upload-file{
        font-weight: 600;
        margin-bottom: 25px;
    }

    div.is-invalid-file + div.invalid-feedback {
      display: block;
    }


    .fileInfo-description{
        margin-left: 10px;
        display: flex;
        flex-direction: column;
    }

    .fileInfo-description-filename{
        font-size: 12px;
        font-weight: 600;
    }

    .fileInfo-description-filesize{
        font-size: 11px;
        color: #666;
    }

    .text-transform-capitalize{
        text-transform: capitalize!important;
    }

    .last-note-card{
        border: 1px solid #e7e7e7;
        border-radius: 6px;
        padding: 10px;
    }

    .preview-icon-uploaded{
        font-size: 35px;
        color: var(--bs-primary);
    }
    #confetti{
        position:absolute;
    }

    .user-cover-small-alert{
        float: initial!important;
        height: 25px!important;
        width: 25px!important;
        margin-right: 1px!important;
        margin-left: 4px!important;
    }

    .label-documentation-verificied{
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        padding: 0px;
        margin: 0px;
    }

    .turn-on-off-visibility{
        right: 0px;
        bottom: 0px;
        margin-bottom: 10px;
        font-size: 20px;
        cursor: pointer;
    }

    input[type="text"] + .turn-off-visibility,
    input[type="password"] + .turn-on-visibility{
        display: none;
    }
    input[type="password"] + .turn-off-visibility,
    input[type="text"] + .turn-on-visibility{
        display: inline-block;
    }
    input[type="password"] {
        user-select: none;
    }

    .label-check-documentation-status{
        border-radius: 6px;
        box-shadow: initial;
        border: 1px solid #dddddd94;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .label-check-documentation-status.checked-label-documentation{
        border-color: var(--bs-primary);
    }

    .label-check-documentation-status:hover
    {
        box-shadow: 0px 0px 0px 4px #0d6efd40;
        border-color: var(--bs-primary);
    }
    .document-not-valid-badge {
        width: 10px;
        padding: 0px;
        height: 10px;
        position: absolute;
        right: 0;
        top: 0;
        margin: 8px 8px 0px 0px;
        border-radius: 50%;
        animation: 1.2s infinite pulse-box-shadow;
    }

    @keyframes pulse-box-shadow {
        0% {
            box-shadow: 0 0 0 0 rgba(193, 65, 65, 0.7);
        }

        70% {
            box-shadow: 0 0 0 5px rgba(193, 65, 65, 0);
        }
        100% {
            box-shadow: 0 0 0 0 transparent;
        }
    }





    </style>
@endsection

@section('js')
<script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/js-confetti.min.js")}}"></script>

<script>

        $(document).ready(function(){
            var hash = window.location.hash;
            if(hash){
                $('.nav-tabs button').removeClass('active');

                $('.tab-pane').removeClass('show active');

                $('.nav-tabs button[data-bs-target="' + hash + '"]').addClass('active');

                $('div[aria-labelledby="' + hash + '"]').addClass('show active');
            }

            $(document).keydown(function(event) {
                if (event.keyCode == 123) {
                    event.preventDefault();
                }
            });

            $(document).keydown(function(event) {
                if (event.ctrlKey && event.keyCode == 83) {
                    event.preventDefault();
                }
            });
        });

        $('.turn-on-off-visibility').on('click', function(){
            var input = $(this).closest('.position-relative').find("input");
            var iconClosed = 'visibility';
            var iconOpen = 'visibility_off';

            if(input.attr('type') === 'password'){
                input.attr('type', 'text');
                $(this).text(iconOpen);
                var that = this; // Armazena o valor de 'this'
                setTimeout(function(){
                    input.attr('type', 'password');
                    $(that).text(iconClosed); // Usa a variável 'that' ao invés de 'this'
                }, (5000)); // 5s em milissegundos
            } else {
                input.attr('type', 'password');
                $(this).text(iconClosed);
            }
        });


        function checkSpecialCharacters(val) {
            const specialCharacters = ["$", ",", "*", "¨", "#", "/", "}", "{", "@", "|", "\\" , "."];
            return specialCharacters.some(char => val.includes(char));
        }

        function checkSpecialCharInput(e){
            const val = $(e).val();
            if (checkSpecialCharacters(val)) {
                $(e).addClass('is-invalid');
            } else {
                $(e).removeClass('is-invalid');
            }
        }


    $("form[name='form-upload-new-material']").on('submit', function (e){
        e.preventDefault();
        $('#blockui-form-upload-material').block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        const form = $(this);
        form.find('button').attr('disabled', true);

        const name = e.target.name;
        const fileInput = e.target.fileInput;

        if (checkSpecialCharacters(name.value) || name.value.trim() === "") {
            name.classList.add('is-invalid');
            $('#blockui-form-upload-material').unblock();
            form.find('button').attr('disabled', false);
            return;
        } else {
            name.classList.remove('is-invalid');
        }

        if (!fileInput.files || fileInput.files.length === 0) {
            fileInput.classList.add('is-invalid-file');
            $('#blockui-form-upload-material').unblock();
            form.find('button').attr('disabled', false);
            return;
        } else {
            fileInput.classList.remove('is-invalid-file');
        }


        const fileInfo = validateFiles(fileInput.files);


        const formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user', "{{ Auth::user()->id }}");
        formData.append('article', "{{ $material->id }}");
        formData.append('name', name.value);
        formData.append('file', fileInfo);
        formData.append('size', ((fileInfo.size / 1024).toFixed(2) + " KB"));
        formData.append('type', (fileInfo.name.split('.').pop().toLowerCase()));

        $.ajax({
            url: "{{ route('client.upload.material', ['id' => $client->id]) }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                addFileToDOM(response);

                showCustomToast("success", {
                    title: "Material enviado com sucesso!",
                    message: "Uhu! Seu material foi salvo com sucesso!",
                });

                $('#blockui-form-upload-material').unblock();
                form.find('button').attr('disabled', false);
                $("#new-material-upload").modal('hide');
            },
            error: function (response) {
                showCustomToast("danger", {
                    title: "Opss...",
                    message: "Algo deu errado. Tente novamente mais tarde.",
                });

                $('#blockui-form-upload-material').unblock();
                form.find('button').attr('disabled', false);
            }
        });
    });


    function addFileToDOM(data) {

        const badge = $("#material-badge-count");
        badge.text(parseInt(badge.text()) + 1);
        var icon = "description";

        if((["jpg","jpeg","png"]).includes(data.extension)){
            var icon = "image";
        }

        const html = `
            <div class="card file-card file-manager-recent-item">
                <div class="p-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="material-icons-outlined text-primary align-middle m-r-sm">${icon}</i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="file-item-title flex-fill">${data.name}</span>
                            <span style="font-size: 11px;">Enviado por: ${data.user_name}</span>
                        </div>
                        <a target="_blank" href="${data.url}" class="file-manager-recent-file-actions">
                            <span class="material-symbols-outlined">download</span>
                        </a>
                    </div>
                </div>
            </div>
        `;

        const todayContainer = $("#today");
        if (!todayContainer.length) {
            $(".events_list").prepend(`
                <div class="events">
                    <div class="events-line position-relative">
                        <span class="event-line-icon-top material-symbols-outlined">trip_origin</span>
                        <div class="events-line-background"></div>
                        <span class="event-line-icon-bottom material-symbols-outlined">trip_origin</span>
                    </div>

                    <div class="d-flex flex-column" style="padding-left: 20px;">
                        <div class="events-date mb-3">Hoje</div>
                        <div class="events-content" id="today">
                            ${html}
                        </div>
                    </div>
                </div>
            `);
        } else {
            todayContainer.prepend(html);
        }
    }


    function allowDrop(event) {
      event.preventDefault();
    }

    function addDragoverClass() {
      document.getElementById('fileDrop').classList.add('dragover');
    }

    function removeDragoverClass() {
      document.getElementById('fileDrop').classList.remove('dragover');
    }

    function clickFileInput() {
      document.getElementById('fileInput').click();
    }

    function handleDrop(event) {
        event.preventDefault();
        const droppedFiles = event.dataTransfer.files;
        if(validateAndShowFileInfo(droppedFiles)){
            const fileInput = document.getElementById('fileInput');
            fileInput.files = droppedFiles;
        }
    }

    function validateAndShowFileInfo(event) {
        var files = event;

            if(files.target){
                files = files.target?.files;
            }

        if (files.length > 0) {
            const validFile = validateFiles(files);
            if (validFile) {
            showFileInfo(validFile);
            document.getElementById('fileDrop').classList.remove('is-invalid-file');
            } else {
            document.getElementById('fileDrop').classList.add('is-invalid-file');
            document.getElementById('fileInfo').innerHTML = ''; // Limpa informações anteriores
            }

            return validFile;
        }
    }


    function validateFiles(files) {
      const allowedExtensions = ["doc", "docx", "pdf", "jpg", "jpeg", "png"];
      const validFiles = Array.from(files).filter(file => {
        const extension = file.name.split('.').pop().toLowerCase();
        return allowedExtensions.includes(extension);
      });

      return validFiles[0];
    }

    function showFileInfo(file) {
      const fileInfo = document.getElementById('fileInfo');

      fileInfo.innerHTML = ''; // Limpa informações anteriores

      const fileSizeKB = (file.size / 1024).toFixed(2);
      const fileSizeMB = (fileSizeKB / 1024).toFixed(2);
      const fileExtension = file.name.split('.').pop().toLowerCase();
        var icon = "description";

        if((["jpg","jpeg","png"]).includes(fileExtension)){
            var icon = "image";
        }

      const fileInfoText = `
          <div class="d-flex mt-3 align-items-center">
              <i class="material-icons preview-icon-uploaded">${icon}</i>
              <div class="fileInfo-description">
                  <span class="fileInfo-description-filename">${file.name}</span>
                  <span class="fileInfo-description-filesize">${fileSizeKB}KB</span>
              </div>
          </div>
      `;
      const fileInfoElement = document.createElement('p');
      fileInfoElement.innerHTML = fileInfoText;

      fileInfo.appendChild(fileInfoElement);
    }


    $("form[name='new-note-message']").on('submit', function (event){
        event.preventDefault();

        const form = $(this);
        form.find('button').attr('disabled', true);
        form.block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        const message = $("#note-message");

        if((message.val()).trim()===""){
            showCustomToast("danger", {
                title: "Opss...",
                message: "Você precisa escrever uma mensagem.",
            });
            message.addClass('is-invalid');
            form.find('button').attr('disabled', false);
            form.unblock();
            return;
        }
        message.removeClass('is-invalid');

        $.ajax({
            url: "{{route('client.store.note', ['id' => $material->id])}}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                user: "{{ Auth::user()->id }}",
                message: message.val(),
            },
            success: function (data) {
                showCustomToast("success", {
                    title: "Nota adicionada com sucesso!",
                    message: "Uhu! Sua nota foi salva com sucesso!",
                });

                const badge = $("#note-badge-count");
                badge.text(parseInt(badge.text()) + 1);

                $("#last-note-name").html(data.user.name);
                $("#last-note-message").html(message.val());

                $("#list-notes").prepend(`
                    <div style=" border-radius: 6px;border: 1px solid #e7e7e7; padding: 15px;" class="col-sm-6 mb-2">
                        <div class="d-flex">
                            <div class="me-3">
                                <img style=" width: 34px; border-radius: 100%; " src="${data.user.cover}" alt="">
                            </div>
                            <div class="d-flex flex-column">
                                <span class="file-item-title flex-fill">
                                    ${data.user.name}
                                </span>
                                <span style="font-size: 11px;">
                                    ${message.val()}
                                </span>
                            </div>
                        </div>
                        <div class="mt-2 w-100 d-flex justify-content-end" style="font-size: 11px;color:#666">
                            ${data.time}
                        </div>
                    </div>
                `);

                form.find('button').attr('disabled', false);
                form.unblock();
                $("#note-message").val("");
            },
            error: function (response) {
                showCustomToast("danger", {
                    title: "Opss...",
                    message: "Algo deu errado. Tente novamente mais tarde.",
                });

                form.find('button').attr('disabled', false);
                form.unblock();
            }
        });
    });

    function turnSuccessDocumentStatus(){
        const ele = $("#DocStatusIcon");
        ele.css("color", "#0aa90a");
        ele.html("gpp_good");
        $("#NotficationBadDocStatus").hide();
    }

    function turnErrorDocumentStatus(){
        const ele = $("#DocStatusIcon");
        ele.css("color", "red");
        ele.html("gpp_bad");
        $("#NotficationBadDocStatus").show();
    }

    function turnMaybeDocumentStatus(){
        const ele = $("#DocStatusIcon");
        ele.css("color", "#f9bb00");
        ele.html("gpp_maybe");
        $("#NotficationBadDocStatus").show();
    }

    function ChangeDocumentStatus(){
        const eleValidDoc = $("input[type='checkbox'][name='documentation_valid']");
        const eleCompleteDoc = $("input[type='checkbox'][name='documentation_complete']");

        $("#documentation").block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        var data = {
            _token: "{{ csrf_token() }}",
            user: "{{ Auth::user()->id }}",
            status: {
                valid: eleValidDoc.is(':checked'),
                complete: eleCompleteDoc.is(':checked'),
            },
        }

        $.ajax({
            url: "{{route('client.change.document.status', ['client' => $client->id])}}",
            type: 'POST',
            data: data,
            success: function (data) {
                if(data.success){
                    showCustomToast("success", {
                        title: "Status do documento alterado com sucesso!",
                        message: "Uhu! O status do documento foi alterado com sucesso!",
                    });

                    if(data.success === true){

                        if(eleCompleteDoc.is(':checked') ){
                            $("#isValid_checkboxInput").prop('disabled', false);
                        }else{
                            eleValidDoc.prop('disabled', true);
                            eleValidDoc.prop('checked', false);
                        }

                        console.log("dadasd")

                        if(eleValidDoc.is(':checked') && eleCompleteDoc.is(':checked')){
                            turnSuccessDocumentStatus()
                        }else if(eleCompleteDoc.is(':checked') && !eleValidDoc.is(':checked')){
                            turnMaybeDocumentStatus();
                        }else{
                            turnErrorDocumentStatus();
                        }
                    }else{
                        showCustomToast("danger", {
                            title: "Opss...",
                            message: "Algo deu errado. Tente novamente mais tarde.",
                        });
                    }
                }
                $("#documentation").unblock();
            },
            error: function (response) {
                showCustomToast("danger", {
                    title: "Opss...",
                    message: "Algo deu errado. Tente novamente mais tarde.",
                });
            }
        })
    }

    $("input[type='checkbox'][name='documentation_complete']").on('change' , function () {
        ChangeDocumentStatus();
    });

    $("input[type='checkbox'][name='documentation_valid']").on('change' , function () {
        ChangeDocumentStatus();
    });

    $(".file-manege-remove").on("cloick", function(){
        const dataIdRemove = $(this).attr("data-id-remove");
        $("#material").block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        $.ajax({
            url: "{{route('client.remove.article.file', ['id' => $material->id])}}",
            type: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                _user: "{{ Auth::user()->id }}",
                id: dataIdRemove,
            },
            success: function (data) {
                $("#material").unblock();
                if(data.success){
                    $(this).remove();
                    showCustomToast("success", {
                        title: "Arquivo removido com sucesso!",
                        message: "Uhu! O arquivo foi removido com sucesso!",
                    });
                }else{
                    showCustomToast("danger", {
                        title: "Opss...",
                        message: "Algo deu errado. Tente novamente mais tarde.",
                    });
                }
            },
            error: function (response) {
                $("#material").unblock();
                showCustomToast("danger", {
                    title: "Opss...",
                    message: "Algo deu errado. Tente novamente mais tarde.",
                });
            }
        })
    })

  </script>

        @php
            $dataNascimento = str_decryptData($client->document->birthday);
        @endphp
      @if((new DateTime($dataNascimento))->modify("+" . calcularIdade($dataNascimento)." years")->format('d/m/Y') == date("d/m/Y"))
        <script>
            $(document).ready(function () {
                const confetti = new JSConfetti();
                confetti.addConfetti({
                    emojis: ['🥳','🎉' ,'🎊'],
                });
                showCustomToast("success", {
                    title: "Uhuu!",
                    message: "Hoje é aniversário do(a) {{$client->name}}! 🥳🎉",
                });
            })
        </script>
    @endif
@endsection

@section('content')
    <canvas id="confetti"></canvas>
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        @if($material->reason_cancellation)
                        <div class="col-sm-12">
                            <div class="page-header">
                               <div class="alert alert-custom" role="alert">
                                    <div class="custom-alert-icon icon-danger mb-0"><i style=" font-size: 50px; " class="material-icons-outlined">close</i></div>
                                    <div class="alert-content">
                                        <span class="alert-title"><span class="text-transform-capitalize">{{$client->name}} {{$client->last_name}}</span>, infelizmente cancelou sua submissão</span>
                                        <span style=" font-size: 11px; " class="alert-text">Submissão cancelada por <b>{{$material->reason_cancellation->users->name}}</b><br class="mb-2"/> motivo: {{$material->reason_cancellation->reasons->label}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="page-description page-description-tabbed ">
                            <div class="d-flex align-items-center">
                                <div class="page-description-content flex-grow-1">
                                    <h1 class="d-flex align-items-center">
                                        @if(!empty($client->address->country))
                                        <div><i title="internacional" class="material-icons text-primary" style=" font-size: 32px; margin-right: 9px; margin-top: 12px; ">public</i></div>
                                        @endif
                                        <div class="text-transform-capitalize">
                                            {{$client->name}} {{$client->last_name}}
                                            <?=getIconStatusDocument($client->document, [
                                                "components" => 'id="DocStatusIcon"',
                                                "class" => "",
                                                "style" => "font-size: 25px;"
                                            ])?>
                                            <span style="font-size: 16px">#{{$client->id}}</span>
                                        </div>
                                    </h1>
                                </div>
                            </div>
                            <div class="w-100 mt-2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="basic_information_tab" data-bs-toggle="tab" data-bs-target="#basic_information" type="button" role="tab" aria-controls="basic_information" aria-selected="true">
                                            Informações do Autor
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="address_tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">
                                            Endereço
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link position-relative" id="documentation_tab" data-bs-toggle="tab" data-bs-target="#documentation" type="button" role="tab" aria-controls="documentation" aria-selected="false">
                                            Documentação
                                            <span style="display: {{!validDocument($client->document)?"block":"none"}}" id="NotficationBadDocStatus" class="document-not-valid-badge badge rounded-pill badge-danger"></span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="submission_tab" data-bs-toggle="tab" data-bs-target="#submission" type="button" role="tab" aria-controls="submission" aria-selected="false">
                                            Submissão
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center" id="material_tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab" aria-controls="material" aria-selected="false">
                                            Arquivos <span id="material-badge-count" class="ms-2 badge badge-style-bordered badge-primary">@if(isset($material->file_all_version)){{count($material->file_all_version)}}@else 0 @endif</span>
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link d-flex align-items-center" id="notes_tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">
                                            Notas <span id="note-badge-count" class="ms-2 badge badge-style-bordered badge-primary">@if(isset($material->notes)){{count($material->notes)}}@else 0 @endif</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">

                                @php
                                    $nascimento = str_decryptData($client->document->birthday);

                                    function calcularIdade($dataNascimento) {
                                        $hoje = new DateTime();
                                        $nascimento = new DateTime($dataNascimento);
                                        $idade = $hoje->diff($nascimento)->y;
                                        return $idade;
                                    }

                                    function proximoAniversario($dataNascimento) {
                                        $hoje = new DateTime();
                                        $nascimento = new DateTime($dataNascimento);
                                        $nascimento->modify("+" . calcularIdade($dataNascimento) + 1 . " years");
                                        $nextBirthday = $nascimento->format('d/m/Y');
                                        if(date('d/m/Y') == (new DateTime($dataNascimento))->modify("+" . calcularIdade($dataNascimento)." years")->format('d/m/Y')){
                                         $nextBirthday = "Hoje!! 🥳🎉";
                                        }
                                        return $nextBirthday;
                                    }
                                @endphp

                                <div class="tab-pane fade show active" id="basic_information" role="tabpanel" aria-labelledby="basic_information">



                                    @if($client->material->url_photo)
                                        <img src="{{\App\Http\Middleware\AwsS3::getFile($client->material->url_photo)}}" width="100px" height="100px" style="border-radius: 5px; margin-bottom: 20px;" />
                                    @endif

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">Nome</label>
                                            <input readonly type="text" value="{{$client->name}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Sobrenome</label>
                                            <input readonly type="text" value="{{$client->last_name}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label  class="form-label">E-mail</label>
                                            <input readonly type="text" value="{{$client->email}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label  class="form-label">Celular</label>
                                            <input readonly type="text" value="{{$client->ddi}} {{$client->cellphone}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-2">
                                            <label class="form-label">Idade</label>
                                            <input readonly type="text" value="{{calcularIdade($nascimento)}} anos" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-2">
                                            <label class="form-label">Próximo Aniversário 🎉</label>
                                            <input readonly type="text" value="{{proximoAniversario($nascimento)}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row ">
                                        <div class="col-sm-8">
                                            <label class="form-label">Última nota</label>
                                            <div class="last-note-card ">
                                                @if(count($material->notes)>0)
                                                @php
                                                    $FirstNote = $material->notes[0];
                                                @endphp
                                                    <div class="d-flex align-items-center">
                                                        <span class="material-symbols-outlined text-primary me-3">
                                                            note_stack
                                                        </span>
                                                        <div class="d-flex flex-column">
                                                            <span id="last-note-name" class="file-item-title flex-fill">
                                                                {{$FirstNote->users->name}}
                                                            </span>
                                                            <span style="font-size: 11px;">
                                                                <span id="last-note-message" >
                                                                    {{$FirstNote->message}}
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="d-flex align-items-center">
                                                        <span class="material-symbols-outlined text-primary me-3">
                                                            note_stack
                                                        </span>
                                                        <div class="d-flex flex-column">
                                                            <span class="file-item-title flex-fill">
                                                                Nenhuma nota encontrada
                                                            </span>
                                                            <span style="font-size: 11px;">
                                                                <span >
                                                                    Nenhuma nota encontrada
                                                                </span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address">
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">País</label>
                                            <input readonly type="text" value="{{isset($client->address->country)?$client->address->country:"Brasil"}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">CEP/Zipcode</label>
                                            <input readonly type="text" value="{{$client->address->zipcode}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    @if($client->address->addressline)
                                        @php
                                            $addressline2 = str_decryptData($client->address->addressline);
                                            $addressline1 = str_decryptData($client->address->addressline2);
                                        @endphp

                                        <div class="row m-b-xxl">
                                            <div class="col-sm-5">
                                                <label  class="form-label">Cidade</label>
                                                <input readonly type="text" value="{{$client->address->city}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                            <div class="col-sm-3">
                                                <label  class="form-label">Estado</label>
                                                <input readonly type="text" value="{{$client->address->state}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row m-b-xxl">
                                            <div class="col-sm-4">
                                                <label  class="form-label">Linha de Endereço 1</label>
                                                <input readonly type="text" value="{{$addressline1}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label  class="form-label">Linha de Endereço 2</label>
                                                <input readonly type="text" value="{{$addressline2}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                        </div>
                                    @else

                                        @php
                                            $number = str_decryptData($client->address->number);
                                            $address = str_decryptData($client->address->address);
                                        @endphp

                                        <div class="row m-b-xxl">
                                            <div class="col-sm-5">
                                                <label  class="form-label">Endereço</label>
                                                <input readonly type="text" value="{{$address}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                            <div class="col-sm-3">
                                                <label  class="form-label">Número</label>
                                                <input readonly type="text" value="{{$number}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                        </div>

                                        <div class="row m-b-xxl">
                                            <div class="col-sm-4">
                                                <label  class="form-label">Bairro</label>
                                                <input readonly type="text" value="{{$client->address->neighborhood}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                            <div class="col-sm-4">
                                                <label  class="form-label">Complemento</label>
                                                <input readonly type="text" value="{{$client->address->complement}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                        </div>


                                        <div class="row m-b-xxl">
                                            <div class="col-sm-6">
                                                <label  class="form-label">Cidade</label>
                                                <input readonly type="text" value="{{$client->address->city}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                            <div class="col-sm-2">
                                                <label  class="form-label">Estado</label>
                                                <input readonly type="text" value="{{$client->address->state}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="tab-pane fade" id="documentation" role="tabpanel" aria-labelledby="#documentation">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">
                                            <label class="card label-check-documentation-status">
                                                <div style=" padding: 12px; font-weight: 500; " class="card-body d-flex justify-content-between">
                                                    <div class="label-documentation-verificied">
                                                        Documentação Completa
                                                    </div>
                                                    <div>
                                                        <div class="form-check form-switch m-0">
                                                            <input {{$client->document->is_complete?"checked":""}} name="documentation_complete" class="form-check-input" type="checkbox">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="card label-check-documentation-status">
                                                <div style=" padding: 12px; font-weight: 500; " class="card-body d-flex justify-content-between">
                                                    <div class="label-documentation-verificied">
                                                        Documentação Verificada
                                                    </div>
                                                    <div>
                                                        <div class="form-check form-switch m-0">
                                                            <input id="isValid_checkboxInput" {{!$client->document->is_complete?"disabled":""}} {{$client->document->is_valid?"checked":""}} name="documentation_valid" class="form-check-input" type="checkbox">
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label  class="form-label">Data de nascimento</label>
                                            <input readonly type="text" value="{{date('d/m/Y', strtotime($nascimento))}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    @php
                                        $rg = str_decryptData($client->document->rg);
                                        $cpf = str_decryptData($client->document->cpf);
                                        $documentInternacional = str_decryptData($client->document->document);
                                    @endphp

                                    @if(!$documentInternacional)
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">RG</label>
                                            <div class="position-relative">
                                                <input readonly type="password" data-bs-toggle="hide" value="{{$rg}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                                <span id="turn-on-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                                                    visibility
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">CPF</label>
                                            <div class="position-relative">
                                                <input readonly type="password" data-bs-toggle="hide" value="{{$cpf}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                                <span id="turn-off-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                                                    visibility
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">Documento de Identificação</label>
                                            <div class="position-relative">
                                                <input readonly type="password" data-bs-toggle="hide" value="{{$documentInternacional}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                                <span id="turn-off-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                                                    visibility
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                </div>
                                <div class="tab-pane fade" id="submission" role="tabpanel" aria-labelledby="submission">

                                    @if($client->material)
                                        @if($client->material->url_photo&&$client->material->size_photo)
                                            <div class="col-sm-8 mb-4">
                                                <label  class="form-label">Foto enviada por {{$client->name}}:</label>
                                                <div class="photo-client-card file-manager-recent-item">
                                                    <div class="p-3">
                                                        <div class="d-flex align-items-center">
                                                            <i class="material-icons-outlined text-primary align-middle m-r-sm">image</i>
                                                            <a href="#" class="file-manager-recent-item-title flex-fill">{{$client->material->name_photo}}</a>
                                                            <span class="p-h-sm">{{$client->material->size_photo}}</span>
                                                            <span class="p-h-sm text-muted">{{date("d-m-Y", strtotime($client->material->created_at))}}</span>
                                                            <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($client->material->url_photo)}}" class="file-manager-recent-file-actions" ><i class="material-icons">download</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Prazo selecionado:</label>
                                            <input readonly type="text" value="{{$client->submission->term_publication_title}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label  class="form-label">Valor do prazo:</label>
                                            <input readonly type="text" value="{{$client->submission->term_publication_price}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Onde {{$client->name}} encontrou a revista:</label>
                                            @if($client->submission->find_us!=="outro")
                                            <input readonly type="text" value="{{$client->submission->find_us}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            @else
                                            <input readonly type="text" value="{{$client->submission->outer_find_us}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Area de {{$client->name}}:</label>
                                            <input readonly type="text" value="{{$client->submission->area}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Observações feitas por {{$client->name}}:</label>
                                            <textarea rows="7" readonly type="text" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword">{{$client->submission->observation}}</textarea>
                                        </div>
                                    </div>
                                </div>




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

                                    if($material->file_all_version){
                                        $groupedData = groupByDate($material->file_all_version);
                                    }else{
                                        $groupedData = [];
                                    }
                                @endphp

                                <div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="#material">

                                    <a data-bs-toggle="modal" data-bs-target="#new-material-upload" class="btn btn-primary button-add-file">
                                        Adicionar arquivo
                                    </a>

                                    <div class="modal fade" id="new-material-upload" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body" id="blockui-form-upload-material">

                                                    <h5 class="title-form-upload-file d-flex justify-content-between">
                                                        <span>Enviar arquivo</span>
                                                        <button style="font-size: 9px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </h5>


                                                    <form action="" name="form-upload-new-material">
                                                        <div class="mb-3">
                                                            <label class="form-label">Nome do arquivo <code>*</code></label>
                                                            <input name="name" onblur="checkSpecialCharInput(this)" type="text" class="form-control">
                                                            <div class="invalid-feedback">
                                                                O nome do arquivo não pode conter [$, *, ¨, #, /, }, {, @, |, \, .]
                                                            </div>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="form-label w-100">
                                                                Clique aqui ou arraste e solte o arquivo <code>*</code>
                                                            </label>
                                                            <div>
                                                                <div id="fileDrop" ondrop="handleDrop(event)" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput()">
                                                                    <span class="material-symbols-outlined" style="font-size: 35px;color: #666;">
                                                                        upload_file
                                                                    </span>
                                                                    <input type="file" id="fileInput" name="fileInput" onchange="validateAndShowFileInfo(event)" accept=".docx, .pdf, .doc, .jpge, .jpg, .png"  style="display: none;">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    O documento deve ser no formato ( docx, doc, pdf, jpge, jpg, png )
                                                                </div>
                                                            </div>
                                                            <div id="fileInfo">
                                                            </div>
                                                        </div>

                                                        <button class="btn btn-primary w-100" style="font-size: 12px">
                                                            Enviar arquivo
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-sm-7">
                                            @if($client->material)
                                                <div class="events_list">

                                                    @if(count($groupedData)>0)

                                                        @foreach ($groupedData as $key => $fileList)
                                                        <div class="events">

                                                            <div class="events-line position-relative">
                                                                <span class="event-line-icon-top material-symbols-outlined">
                                                                    trip_origin
                                                                </span>
                                                                <div class="events-line-background"></div>
                                                                <span class="event-line-icon-bottom material-symbols-outlined">
                                                                    trip_origin
                                                                </span>
                                                            </div>


                                                            <div class="d-flex flex-column" style="padding-left: 20px;">
                                                                <div class="events-date mb-3"><?php echo $key === "Hoje" ? $key : \Carbon\Carbon::parse($key)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') ?></div>

                                                                <div class="d-flex flex-column p-0 m-0" @if($key==="Hoje")id="today"@endif>
                                                                    @foreach ($fileList as $file)
                                                                    <div class="card file-card file-manager-recent-item">
                                                                        <div class="p-3">
                                                                            <div class="d-flex align-items-center">
                                                                                <div>
                                                                                    @php
                                                                                        $icon = "description";
                                                                                        if(in_array($file['extension'], ['jpg', 'jpeg', 'png'])){
                                                                                            $icon = "image";
                                                                                        }
                                                                                    @endphp
                                                                                    <i class="material-icons-outlined text-primary align-middle m-r-sm">{{$icon}}</i>
                                                                                </div>
                                                                                <div class="d-flex flex-column">
                                                                                    <span class="file-item-title flex-fill">
                                                                                        @if($file)
                                                                                            {{$file['label']}}
                                                                                        @endif
                                                                                    </span>
                                                                                    <span style="font-size: 11px;">
                                                                                        @if($file)
                                                                                            <span>
                                                                                                @if($file['users'])
                                                                                                    Enviado por: {{$file['users']['name']}}
                                                                                                @else
                                                                                                    Enviado pelo autor <b class="text-transform-capitalize">{{$client->name}}</b>
                                                                                                @endif
                                                                                            </span>
                                                                                        @endif
                                                                                    </span>
                                                                                </div>
                                                                                <div class="d-flex align-item-center justify-content-end w-100">
                                                                                    @if($file['users'])
                                                                                    <a data-id-remove="{{$file->id}}" class="file-manager-recent-file-actions file-manege-remove" >
                                                                                        <span class="material-symbols-outlined text-danger">
                                                                                            delete
                                                                                        </span>
                                                                                    </a>
                                                                                    @endif
                                                                                    <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($file['url_material'])}}" class="file-manager-recent-file-actions" >
                                                                                        <span class="material-symbols-outlined">
                                                                                            download
                                                                                        </span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>

                                                        </div>
                                                        @endforeach

                                                    @endif

                                                </div>
                                            @endif
                                        </div>


                                    </div>
                                </div>


                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="#notes">
                                    <form name="new-note-message" class="col-sm-6">
                                        <label class="form-label">Mensagem</label>
                                        <textarea name="note-message" id="note-message" rows="4" class="form-control mb-3" placeholder="Escreva aqui..."></textarea>
                                        <div class="col-sm-12 mb-3">
                                            <div style=" padding-left: 1.5rem; " class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" id="is_task" name="is_task">
                                                <label class="form-check-label" for="is_task" style="font-size: 12px">Tornar uma tarefa</label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary button-add-note">
                                            Adicionar nota
                                        </button>
                                    </form>

                                    @if($material->notes)
                                        <div id="list-notes" class="d-flex flex-column col-sm-12">
                                            @foreach ($material->notes as $note)
                                                <div style=" border-radius: 6px;border: 1px solid #e7e7e7; padding: 15px;" class="col-sm-6 mb-2">
                                                    <div class="d-flex">
                                                        <div class="me-3">
                                                            <img style=" width: 34px; border-radius: 100%; " src="{{photo_user($note->users->cover)}}" alt="">
                                                        </div>
                                                        <div class="d-flex flex-column">
                                                            <span class="file-item-title flex-fill">
                                                                {{$note->users->name}}
                                                            </span>
                                                            <span style="font-size: 11px;">
                                                                {{$note->message}}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 w-100 d-flex justify-content-end" style="font-size: 11px;color:#666">
                                                        {{date('d/m/Y \á\s H:i', strtotime($note->created_at))}}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

