@extends('main._index')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{custom_asset("/template/assets/css/flatpickr.min.css")}}">

    <style>
    .flatpickr-current-month{
        font-size: 13px;
        padding-top: 15px;
    }
    .flatpickr-day{
        font-size: 12px;
    }
    span.flatpickr-weekday{
        font-size: 12px;
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

   .file-card{
        margin-left: -2px;
        border: 1px solid #e7e7e7;
        box-shadow: none;
    }
    .file-item-title{
        max-width: 340px;
        font-weight: 600!important;
        font-size: 12px!important;
        color: black;
        text-decoration: none;
    }

    .file-item-title:hover{
        color: var(--bs-primary);
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

    .card-submissions-item {
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 7px;
        align-items: center;
    }

    .button-submit{
        font-size: 12px;
        font-weight:600;
        padding:10px;
        width: fit-content;
    }

    .badge-count-information-submitions span{
        text-decoration: none!important;
    }

    .badge-count-information-submitions {
        display: flex;
        border-radius: 5px!important;
        align-items: center;
        font-size: 10px;
        padding: 1.5px 2px!important;
        border-color: #4c4f52!important;
        color: #4c4f52;
        transition: all .3s ease-in-out;
        cursor: pointer;
        line-height: 7px;
        text-decoration: none!important;
    }
    .badge-count-information-submitions:hover{
        color: var(--bs-primary)!important;
        border-color: var(--bs-primary)!important;
    }

    .dropdown-button-choose-status{
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 600
    }

    </style>


@endsection

@section('js')
    <script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
    <script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>
    <script src="{{custom_asset("/template/assets/js/flatpickr.js")}}"></script>


    <script>
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


    $("form[name='form-upload-new-author']").on('submit', function (e){
        e.preventDefault();
        $('#blockui-form-upload-author').block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        const form = $(this);
        form.find('button').attr('disabled', true);

        const name = e.target.name;
        const fileInput = e.target.fileInput;

        if (checkSpecialCharacters(name.value) || name.value.trim() === "") {
            name.classList.add('is-invalid');
            $('#blockui-form-upload-author').unblock();
            form.find('button').attr('disabled', false);
            return;
        } else {
            name.classList.remove('is-invalid');
        }

        if (!fileInput.files || fileInput.files.length === 0) {
            fileInput.classList.add('is-invalid-file');
            $('#blockui-form-upload-author').unblock();
            form.find('button').attr('disabled', false);
            return;
        } else {
            fileInput.classList.remove('is-invalid-file');
        }


        const fileInfo = validateFiles(fileInput.files);


        const formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('user', "{{ Auth::user()->id }}");
        formData.append('author', "{{ $author->id }}");
        formData.append('name', name.value);
        formData.append('file', fileInfo);
        formData.append('size', ((fileInfo.size / 1024).toFixed(2) + " KB"));
        formData.append('type', (fileInfo.name.split('.').pop().toLowerCase()));

        $.ajax({
            url: "{{ route('author.upload', ['id' => $author->id]) }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                addFileToDOM(response);

                showCustomToast("success", {
                    title: "author enviado com sucesso!",
                    message: "Uhu! Seu author foi salvo com sucesso!",
                });

                $('#blockui-form-upload-author').unblock();
                form.find('button').attr('disabled', false);
                $("#new-author-upload").modal('hide');
            },
            error: function (response) {
                showCustomToast("danger", {
                    title: "Opss...",
                    message: "Algo deu errado. Tente novamente mais tarde.",
                });

                $('#blockui-form-upload-author').unblock();
                form.find('button').attr('disabled', false);
            }
        });
    });


    function addFileToDOM(data) {

        const badge = $("#author-badge-count");
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
                            <i class="author-icons-outlined text-primary align-middle m-r-sm">${icon}</i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="file-item-title flex-fill">${data.name}</span>
                            <span style="font-size: 11px;">Enviado por: ${data.user_name}</span>
                        </div>
                        <a target="_blank" href="${data.url}" class="file-manager-recent-file-actions">
                            <span class="author-symbols-outlined">download</span>
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
                        <span class="event-line-icon-top author-symbols-outlined">trip_origin</span>
                        <div class="events-line-background"></div>
                        <span class="event-line-icon-bottom author-symbols-outlined">trip_origin</span>
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
              <i class="material-symbols-outlined author-icons preview-icon-uploaded">${icon}</i>
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
            url: "{{route('author.store.note', ['id' => $author->id])}}",
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
            url: "{{route('client.change.document.status', ['client' => $author->id])}}",
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

    $('.turn-on-off-visibility').on('click', function(){
        var input = $(this).closest('.position-relative').find("input");
        var iconClosed = 'visibility';
        var iconOpen = 'visibility_off';

        if(input.attr('type') === 'password'){
            input.attr('type', 'text');
            $(this).text(iconOpen);
            var that = this;
            setTimeout(function(){
                input.attr('type', 'password');
                $(that).text(iconClosed);
            }, (5000)); // 5s em milissegundos
        } else {
            input.attr('type', 'password');
            $(this).text(iconClosed);
        }
    });




    $(document).ready(function () {
        $(".flatpickr-date-birthDay").flatpickr();

        // -------- Basic information form
        $('form[name="submit-update-information"]').submit(function (e) {
            e.preventDefault();
            var form = e.target;
            const formData = new FormData(form);

            $(form).find('.is-invalid').removeClass('is-invalid');

            $(form).validate({
                rules: {
                    name: "required",
                    last_name: "required",
                    cellphone: "required",
                    ddi: "required",
                    email: {
                        required: true,
                        email: true
                    }
                },
                errorPlacement: function(error, element) {
                    element.addClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.success){
                                showCustomToast("success", {
                                    title: "Uhuu!",
                                    message: "Informações atualizadas com sucesso!",
                                });
                                $("#author-display-header-name").html(response.name + " " + response.last_name);
                            }else{
                                showCustomToast("error", {
                                    title: "Opss!",
                                    message: "Não foi possível atualizar as informações!",
                                });
                            }
                        },
                        error: function (response) {
                            showCustomToast("error", {
                                title: "Opss!",
                                message: "Não foi possível atualizar as informações!",
                            });
                        }
                    });
                }
            });
        });

        // -------- Address form
        $('form[name="submit-update-address"]').submit(function (e) {
            e.preventDefault();
            var form = e.target;
            const formData = new FormData(form);

            const from_brazil = $(form).find("#from_brazil");
            $(form).find('.is-invalid').removeClass('is-invalid');

            const rules = {
                zip_code: "required",
            };

            if (from_brazil.is(':checked')) {
                Object.assign(rules, {
                    street: "required",
                    address: "required",
                    number: "required",
                    neighborhood: "required",
                });
            } else {
                Object.assign(rules, {
                    addressline1: "required",
                    international_country: "required",
                    international_city: "required",
                    international_state: "required",
                });
            }

            $(form).validate({
                rules: rules,
                errorPlacement: function(error, element) {
                    element.addClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.success){
                                showCustomToast("success", {
                                    title: "Uhuu!",
                                    message: "Endereço atualizadas com sucesso!",
                                });
                            }else{
                                showCustomToast("error", {
                                    title: "Opss!",
                                    message: "Não foi possível atualizar os endereços",
                                });
                            }
                        },
                        error: function (response) {
                            showCustomToast("error", {
                                title: "Opss!",
                                message: "Não foi possível atualizar os endereços",
                            });
                        }
                    });
                }
            });
        });

        $("#address_from_brazil").change(function(){
            if($(this).is(":checked")){
                $("#nacional_mode").show();
                $("#internacional_mode").hide();
            }else{
                $("#nacional_mode").hide();
                $("#internacional_mode").show();
            }
        });


        $("#doc_from_brazil").change(function(){
            if($(this).is(":checked")){
                $("#national_document").show();
                $("#international_document").hide();
            }else{
                $("#national_document").hide();
                $("#international_document").show();
            }
        });

        // -------- Documetation form
        $('form[name="submit-update-documentation"]').submit(function (e) {
            e.preventDefault();
            var form = e.target;
            const formData = new FormData(form);

            $(form).find('.is-invalid').removeClass('is-invalid');

            const from_brazil = $(form).find("#from_brazil");

            const rules = {
                birthday: "required"
            };

            if (from_brazil.is(':checked')) {
                Object.assign(rules, {
                    rg: "required",
                    cpf: "required"
                });
            } else {
                Object.assign(rules, {
                    international_doc: "required",
                });
            }

            $(form).validate({
                rules:rules,
                errorPlacement: function(error, element) {
                    element.addClass('is-invalid');
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            if(response.success){
                                showCustomToast("success", {
                                    title: "Uhuu!",
                                    message: "Documentos atualizados com sucesso!",
                                });

                                const eleValidDoc = $("input[type='checkbox'][name='documentation_valid']");
                                const eleCompleteDoc = $("input[type='checkbox'][name='documentation_complete']");
                                eleValidDoc.prop('checked' , false);
                                eleCompleteDoc.prop('checked' , false);
                                turnErrorDocumentStatus();

                            }else{
                                showCustomToast("error", {
                                    title: "Opss!",
                                    message: "Não foi possível atualizar os documentos...",
                                });
                            }
                        },
                        error: function (response) {
                            showCustomToast("error", {
                                title: "Opss!",
                                message: "Não foi possível atualizar os documentos...",
                            });
                        }
                    });
                }
            });
        });


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
        formData.append('name', name.value);
        formData.append('file', fileInfo);
        formData.append('size', ((fileInfo.size / 1024).toFixed(2) + " KB"));
        formData.append('type', (fileInfo.name.split('.').pop().toLowerCase()));

        $.ajax({
            url: "{{ route('author.upload', ['id' => $author->id]) }}",
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

    });
</script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">


                        <div class="page-description page-description-tabbed ">
                            <div class="d-flex align-items-center">
                                <div class="page-description-content flex-grow-1">
                                    <h1 class="d-flex align-items-center">
                                        <div class="text-transform-capitalize">
                                            <span id="author-display-header-name">{{$author->name}} {{$author->last_name}}</span>
                                            <?=getIconStatusDocument($author->document, [
                                                "components" => 'id="DocStatusIcon"',
                                                "class" => "",
                                                "style" => "font-size: 25px;"
                                            ])?>
                                            <span style="font-size: 16px">#{{$author->id}}</span>
                                        </div>
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item active" role="presentation">
                                <button class="nav-link active d-flex align-items-center" id="notes_tab" data-bs-toggle="tab" data-bs-target="#submissions" type="button" role="tab" aria-controls="submissions" aria-selected="false">
                                    Submissões <span id="submissions-badge-count" class="ms-2 badge badge-style-bordered badge-primary">{{count($author->article)}}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="basic_information_tab" data-bs-toggle="tab" data-bs-target="#basic_information" type="button" role="tab" aria-controls="basic_information" aria-selected="true">
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
                                    <span style="display: {{!validDocument($author->document)?"block":"none"}}" id="NotficationBadDocStatus" class="document-not-valid-badge badge rounded-pill badge-danger"></span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center" id="material_tab" data-bs-toggle="tab" data-bs-target="#files" type="button" role="tab" aria-controls="files" aria-selected="false">
                                    Arquivos <span id="author-badge-count" class="ms-2 badge badge-style-bordered badge-primary">{{count($author->files)}}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center" id="notes_tab" data-bs-toggle="tab" data-bs-target="#notes" type="button" role="tab" aria-controls="notes" aria-selected="false">
                                    Notas <span id="note-badge-count" class="ms-2 badge badge-style-bordered badge-primary">{{count($author->notes)}}</span>
                                </button>
                            </li>
                        </ul>


                        <div class="card">
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="submissions" role="tabpanel" aria-labelledby="#submissions">
                                        @include('pages.author.componets.tab._submissions', ['author' => $author])
                                    </div>

                                    <div class="tab-pane fade " id="basic_information" role="tabpanel" aria-labelledby="basic_information">
                                        @include('pages.author.componets.tab._basic_information', ['author' => $author])
                                    </div>

                                    <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address">
                                        @include('pages.author.componets.tab._address', ['author' => $author])
                                    </div>

                                    <div class="tab-pane fade" id="documentation" role="tabpanel" aria-labelledby="#documentation">
                                        @include('pages.author.componets.tab._documents', ['author' => $author])
                                    </div>

                                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="#files">
                                        @include('pages.author.componets.tab._files', ['author' => $author])
                                    </div>

                                    <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="#notes">
                                        @include('pages.author.componets.tab._notes', ['author' => $author])
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
