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

    </style>
@endsection

@section('js')
<script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>

<script>

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
        const html = `
            <div class="card file-card file-manager-recent-item">
                <div class="p-3">
                    <div class="d-flex align-items-center">
                        <div>
                            <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
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

    function validateAndShowFileInfo(event) {
      const files = event.target.files;
      const validFile = validateFiles(files);

      if (validFile) {
        showFileInfo(validFile);
        document.getElementById('fileDrop').classList.remove('is-invalid-file');
      } else {
        document.getElementById('fileDrop').classList.add('is-invalid-file');
        document.getElementById('fileInfo').innerHTML = ''; // Limpa informações anteriores
      }
    }

    function handleDrop(event) {
      event.preventDefault();
      const droppedFiles = event.dataTransfer.files;
      validateAndShowFileInfo(droppedFiles);
    }

    function validateFiles(files) {
      // Filtra apenas os arquivos DOCX ou PDF
      const allowedExtensions = ["docx", "pdf"];
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

      const fileInfoText = `
          <div class="d-flex mt-3 align-items-center">
              <img width="35px" height="35px" src="<?= custom_asset('/template/assets/images/icons/') ?>/${fileExtension}-icon.png" alt="">
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
                                        @if(!empty($client->address->country))
                                        <div><i title="internacional" class="material-icons text-primary" style=" font-size: 32px; margin-right: 9px; margin-top: 12px; ">public</i></div>
                                        @endif
                                        <div class="text-transform-capitalize">
                                            {{$client->name}} {{$client->last_name}} <span style="font-size: 16px">#{{$client->id}}</span>
                                        </div>
                                    </h1>
                                </div>
                            </div>
                            <div class="w-100 mt-2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="basic_information_tab" data-bs-toggle="tab" data-bs-target="#basic_information" type="button" role="tab" aria-controls="basic_information" aria-selected="true">Informações de Contato</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="address_tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Endereço</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="submission_tab" data-bs-toggle="tab" data-bs-target="#submission" type="button" role="tab" aria-controls="submission" aria-selected="false">Submissão</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="material_tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab" aria-controls="material" aria-selected="false">Material</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="basic_information" role="tabpanel" aria-labelledby="basic_information">
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

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label  class="form-label">E-mail</label>
                                            <input readonly type="text" value="{{$client->email}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label  class="form-label">Celular</label>
                                            <input readonly type="text" value="{{$client->ddi}} {{$client->cellphone}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
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
                                            $addressline2 = \App\Http\Middleware\Cryptography::decrypt($client->address->addressline);
                                            $addressline1 = \App\Http\Middleware\Cryptography::decrypt($client->address->addressline2);
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
                                        $number = \App\Http\Middleware\Cryptography::decrypt($client->address->number);
                                        $address = \App\Http\Middleware\Cryptography::decrypt($client->address->address);
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
                                            <label  class="form-label">Prazo escolhido por {{$client->name}}:</label>
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




                                <div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="material">

                                    <a data-bs-toggle="modal" data-bs-target="#new-material-upload" class="btn btn-primary button-add-file">
                                        Adicionar material
                                    </a>

                                    <div class="modal fade" id="new-material-upload" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body" id="blockui-form-upload-material">

                                                    <h5 class="title-form-upload-file d-flex justify-content-between">
                                                        <span>Enviar Material</span>
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
                                                                    <input type="file" id="fileInput" name="fileInput" onchange="validateAndShowFileInfo(event)" accept=".docx, .pdf"  style="display: none;">
                                                                </div>
                                                                <div class="invalid-feedback">
                                                                    O documento deve ser no formato ( docx, doc, pdf )
                                                                </div>
                                                            </div>
                                                            <div id="fileInfo">
                                                            </div>
                                                        </div>

                                                        <button class="btn btn-primary w-100" style="font-size: 12px">
                                                            Enviar material
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
                                                                                    <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                                                                </div>
                                                                                <div class="d-flex flex-column">
                                                                                    <span class="file-item-title flex-fill">
                                                                                        @if($file)
                                                                                            {{$file['label']}}
                                                                                        @endif
                                                                                    </span>
                                                                                    <span style="font-size: 11px;">
                                                                                        @if($file)
                                                                                            <span >
                                                                                                @if($file['users'])
                                                                                                    Enviado por: {{$file['users']['name']}}
                                                                                                @else
                                                                                                    Enviado pelo autor <b class="text-transform-capitalize">{{$client->name}}</b>
                                                                                                @endif
                                                                                            </span>
                                                                                        @endif
                                                                                    </span>
                                                                                </div>
                                                                                <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($file['url_material'])}}" class="file-manager-recent-file-actions" >
                                                                                    <span class="material-symbols-outlined">
                                                                                        download
                                                                                    </span>
                                                                                </a>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

