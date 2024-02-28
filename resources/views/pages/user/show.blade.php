@extends('main._index')

@section('css')
<link rel="stylesheet" href="{{custom_asset("/template/assets/css/select2.min.css")}}">
<style>
    .title-id-user{
        font-size: 14px;
    }
    .title-image-user{
        width: 55px;
        height: 55px;
        border-radius: 9px;
    }
    .title-roles-user{
        font-size: 13px;
        font-weight: 600;
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

    .button-submit-user-update{
        font-size: 12px;
        font-weight: 600;
        padding: 10px;
    }


    /** SELECT2 TAG INPUT*/
    .select2-container--default .select2-selection--multiple {
        padding: 4px 10px 10px 5px!important;
        display: flex!important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        border: transparent;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        padding: 6px 12px!important;
        width: fit-content !important;
        height: fit-content !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove{
        padding: 0px 4px 0px 0px !important;
        transition: color 0.3s ease-in-out;
        color: var(--bs-primary);
    }

    .select2-selection__choice__remove:hover{
        background-color: transparent!important;
        color: var(--bs-danger)!important;
    }

    .select2-container--default .select2-results__option--selected {
        font-size: 12px;
        font-weight: 600!important;
    }

    .select2-container--default .select2-results__option--highlighted.select2-results__option--selectable {
        background-color: #5897fb;
        color: white !important;
    }
    .select2-results__option {
        border-radius: 3px!important;
        font-size: 12px!important;
        font-weight: 600!important;
        margin-bottom: 4px!important;
    }

    .select2-container--default .select2-results__option--selected {
        background: #dff0fe;
        color: #2269f5;
        border: none;
    }
    .select2-container--default .select2-search--inline .select2-search__field{
        height: 100%;
        margin: 3px;
        padding: 2px;
    }
</style>
@endsection

@section('js')
<script src="{{custom_asset("/template/assets/js/select2.min.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>

<script>

    function handleDrop(event, inputId) {
        event.preventDefault();
        removeDragoverClass();
        validateAndShowFileInfo(event, inputId);
    }

    function clickFileInput(inputId) {
        document.getElementById(inputId).click();
    }

    function validateAndShowFileInfo(event, inputId) {
        const fileList = event.target.files || event.dataTransfer.files; // Handle both click and drop events

        const validExtensions = ['.jpeg', '.jpg', '.png'];
        const fileInfoContainer = document.getElementById(`${inputId}Preview`);
        const invalidFeedback = document.querySelector('.invalid-feedback');

        fileInfoContainer.innerHTML = '';

        for (let i = 0; i < fileList.length; i++) {
            const file = fileList[i];
            const fileName = file.name;
            const fileExtension = fileName.substring(fileName.lastIndexOf('.')).toLowerCase();
            const fileSizeKB = (file.size / 1024).toFixed(2);
            var icon = "image";

            const html = `
                <div class="d-flex mt-3 align-items-center">
                    <i class="material-symbols-outlined author-icons preview-icon-uploaded text-primary">${icon}</i>
                    <div class="fileInfo-description">
                        <span class="fileInfo-description-filename">${fileName}</span>
                        <span class="fileInfo-description-filesize">${fileSizeKB}KB</span>
                    </div>
                </div>
            `;

            if (validExtensions.includes(fileExtension)) {
                $(`#${inputId}`).removeClass('is-invalid');
                fileInfoContainer.innerHTML += html;
            } else {
                $(`#${inputId}`).addClass('is-invalid');
            }
        }
    }







    $('form[name="submit-user-update"]').on("submit", function(event) {
        event.preventDefault();

        if (!$(this).valid()) {
            showCustomToast("danger", {
                title: "Opss...",
                message: `Campos obrigatórios não preenchidos e/ou inválidos!`,
            });
            return;
        }

        $("#userCard").block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        const form = event.target;
        const formData = new FormData(form);
        const url = form.action;
        const method = form.method;
        formData.append('user', '{{auth()->user()->id}}');

        $.ajax({
            url,
            method,
            data: formData,
            processData: false,
            contentType: false,
            success: (data) => {
                console.log(data);
                if(data.success){
                    $("#userCard").unblock();
                    showCustomToast("success", {
                        title: "Colaborador cadastrado com sucesso!",
                        message: `Usuário cadastrado com sucesso!`,
                    });
                }
            },
            error: (err) => {
                console.error(err);
            }
        })
    })


    $('form[name="submit-user-update"]').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: function() {
                    return ($("#password").val()).length>0;
                },
                minlength: function() {
                    return ($("#password").val()).length>0?8:0;
                }
            },
            password_confirmation: {
                equalTo: function() {
                    return ($("#password").val()).length>0?"#password":"";
                }
            },
            roles: {
                required: true
            }
        },
        errorPlacement: function(error, element) {
            $(element).removeClass('is-valid').addClass('is-invalid');
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        }
    });

      $(document).ready(function () {
        $(".rolesMultiSelector").select2();
      });
</script>
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-0 pt-2 mb-2 page-description page-description-tabbed d-flex align-items-center">
                        <img class="title-image-user me-3" src="{{photo_user($auth->cover)}}" alt="">
                        <div>
                            <h1>{{$auth->name}} <span class="title-id-user" >#{{$auth->id}}</span></h1>
                            <div class="title-roles-user">
                                @foreach ($auth->permissions as $permission)
                                    {{$permission->label}}@if(!$loop->last),@endif
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="true">Perfil</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
                            <div class="card" id="userCard" >
                                <div class="card-body">
                                    <form method="POST" name="submit-user-update" action="{{route("user.update", ["id" => $auth->id])}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="row mb-4">
                                            <div class="col-sm-4">
                                                <label class="form-label w-100">
                                                    Clique aqui ou arraste e solte a foto de usuário
                                                </label>
                                                <div>
                                                    <div data-bs-from="fileInputPhotoUser" id="fileDrop" ondrop="handleDrop(event, 'fileInputPhotoUser')" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput('fileInputPhotoUser')">
                                                        <span class="material-symbols-outlined" style="font-size: 35px;color: var(--bs-primary);">
                                                            photo_camera_front
                                                        </span>
                                                        <input data-bs-from="fileInputPhotoUser" type="file" id="fileInputPhotoUser" name="fileInputPhotoUser" onchange="validateAndShowFileInfo(event, 'fileInputPhotoUser')" accept=".jpeg, .jpg, .png"  style="display: none;">
                                                    </div>
                                                    <div class="invalid-feedback">
                                                        O documento deve ser no formato ( jpeg, jpg, png )
                                                    </div>
                                                </div>
                                                <div class="fileInfo" id="fileInputPhotoUserPreview">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Nome <code>*</code></label>
                                                <input value="{{$auth->name}}" type="text" class="form-control" id="name" name="name" placeholder="">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">E-mail <code>*</code></label>
                                                <input value="{{$auth->email}}" type="email" class="form-control" name="email" id="email" placeholder="examplo@exemplo.com">
                                                <div class="form-text">O e-mail deve ser válido</div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label for="settingsInputFirstName" class="form-label">Senha</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="**********">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="settingsInputEmail" class="form-label">Confirmar senha</label>
                                                <input type="password" class="form-control" name="confirm-password" id="confirm-password" placeholder="**********">
                                                <div class="form-text">As duas senha devem ser iguais</div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-md-6">
                                                <label for="settingsInputFirstName" class="form-label">Função</label>
                                                <select class="form-select rolesMultiSelector" name="roles[]" id="roles" multiple="multiple">
                                                    @foreach ($roles as $role)
                                                        <option value="{{$role->id}}" @if($auth->permissions->contains($role)) selected @endif>{{$role->label}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row m-t-lg">
                                            <div class="col">
                                                <button type="submit" class="btn btn-primary m-t-sm button-submit-user-update">Atualizar usuário</button>
                                            </div>
                                        </div>

                                    </form>
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
