@extends('main._index')

@section('css')
<style>
    .user-cover{
        border-radius: 8px;
        min-width: 32px;
        max-width: 32px;
        min-height: 32px;
        max-height: 32px;
    }

    .user-activity-online-table .activity-indicator-table{
        background: #08e57f;
        display: block;
        width: 7px;
        border-radius: 100%;
        height: 7px;
        box-shadow: 0px 0px 0px 2px #00bd65;
        position: absolute;
        left: 100%;
        bottom: 0px;
        margin-left: -6px;
    }

    .user-activity-online-table{
        position:relative;
    }

    .div-form-check-active{
        height: 39px;
        display: flex!important;
        padding: 0px;
        flex-direction: column;
        position: relative;
        align-items: center;
        justify-content: center;
        padding-left: 30px!important;
    }

    .div-form-check-active input{
        width: 37px!important;
        height: 20px!important;
    }

    .ModalButtonAddNewUser{
        width: fit-content;
        font-size: 12px;
        font-weight: 600;
    }

    .btnCloseModalNewUser{
        width: 0.3em!important;
        height: 0.3em!important;
    }

    .select2-container{
        width: 100% !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field{
        width: 100% !important;
        padding: 7px;
        margin-bottom: 10px;
        font-size: 12px;
    }
    .select2-container--default .select2-results__option--selected,
    .select2-container--default .select2-results__option[aria-selected=true]{
        padding: 8px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 500;

        transition: background-color 0.1s ease-in-out;
    }
    .select2-container--default .select2-results__option[aria-selected=true]{
        color: white!important
    }
    .select2-results__option--selectable {
        cursor: pointer;
        font-size: 12px;
        font-weight: 600;
        border-radius: 5px;
    }
    .select2-results__option {
        font-size: 12px;
        font-weight: 500;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }

    .select2-container.select2-container--default.select2-container--open{
        z-index: 10000000!important;
    }

    .select2-container--default .select2-results__option[aria-selected=true] {
        font-weight: 400!important;
        padding: 6px!important;
    }

    .select2-container--default .select2-results__option--selected{
        padding: 6px!important;
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

</style>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection


@section('js')
<script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
<script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
       $('.select-userRole').select2();

        $(".input-change-status-user").on('change', function(){
            const status = $(this).is(':checked')?1:0;
            const id = $(this).attr('data-id');
            $("#blockui-card-1").block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            $.ajax({
                url: `{{route('user.changeStatus')}}`,
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    _user: '{{auth()->user()->id}}',
                    id,
                    status
                },
                success: (data) => {
                    $("#blockui-card-1").unblock();
                    if(data.success){
                        showCustomToast("success", {
                            title: "Status alterado com sucesso!",
                            message: `O status do colaborador foi alterado com sucesso!`,
                        });
                    }
                },
                error: (err) => {
                    $("#blockui-card-1").unblock();
                    console.error(err);
                }
            })
        });


    });

    document.addEventListener('DOMContentLoaded', function() {
        var campos = document.querySelectorAll('input, textarea');

        campos.forEach(function(campo) {
            campo.setAttribute('autocomplete', 'off');
        });
    });


    $('form[name="formSaveUser"]').on("submit", function(event) {
        event.preventDefault();

        if (!$(this).valid()) {
            showCustomToast("danger", {
                title: "Opss...",
                message: `Campos obrigatórios não preenchidos e/ou inválidos!`,
            });
            return;
        }

        $("#ModalAddNewUser").block({
            message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
        });

        const form = event.target;
        const formData = new FormData(form);
        const url = form.action;
        const method = form.method;

        formData.append('_token', '{{csrf_token()}}');
        formData.append('user', '{{auth()->user()->id}}');

        $.ajax({
            url,
            method,
            data: formData,
            processData: false,
            contentType: false,
            success: (data) => {
                if(data.success){
                    $("#ModalAddNewUser").unblock();
                    $("#ModalAddNewUser").modal('hide');
                    showCustomToast("success", {
                        title: "Colaborador cadastrado com sucesso!",
                        message: `Usuário cadastrado com sucesso!`,
                    });
                    window.location.reload();
                }
            },
            error: (err) => {
                window.location.reload();
                console.error(err);
            }
        })
    })


    $('form[name="formSaveUser"]').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                minlength: 8
            },
            password_confirmation: {
                required: true,
                equalTo: "#password"
            },
            role: {
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


</script>
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-0 pt-2 page-description page-description-tabbed">
                        <h1>Colaboradores <span class="text-primary">Dasckup</span></h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-3">
                <a class="ModalButtonAddNewUser btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#ModalAddNewUser">Cadastrar Colaborador</a>
            </div>

            <div class="modal fade" id="ModalAddNewUser" tabindex="-1" aria-labelledby="ModalAddNewUser" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="col-sm-12 mb-3 d-flex align-items-center justify-content-between">
                                <h5 style="font-weight: 600" class="m-0">Cadastrar Colaborador</h5>
                                <button type="button" class="btn-close btnCloseModalNewUser" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form name="formSaveUser" method="POST" action="{{route('user.store')}}">
                                <div class="row mb-3 mt-3">
                                    <div class="col-sm-12">
                                        <label class="form-label w-100">
                                            Clique aqui ou arraste e solte a foto de usuário
                                        </label>
                                        <div>
                                            <div data-bs-from="fileInputPhotoUser" id="fileDrop" ondrop="handleDrop(event, 'fileInputPhotoUser')" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput('fileInputPhotoUser')">
                                                <span class="material-symbols-outlined" style="font-size: 35px;color: #666;">
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

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="name" class="form-label">Nome <code>*</code></label>
                                        <input type="text" class="form-control" name="name" id="name" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="email" class="form-label">E-mail <code>*</code></label>
                                        <input type="email" name="email" id="email_fake" autocomplete="off" class="form-control" style="display: none;" />
                                        <input type="email" name="email" id="email_fake" autocomplete="off" class="form-control" style="display: none;" />
                                        <input type="email" name="email" id="email"  autocomplete="off"  class="form-control" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <label for="password" class="form-label">Senha <code>*</code></label>
                                        <input type="password" name="password" id="password_fake" autocomplete="off" style="display: none;" />
                                        <input autocomplete="off" type="password" class="form-control" name="password" id="password" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="password_confirmation" class="form-label">Confirmar Senha <code>*</code></label>
                                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" />
                                    </div>
                                    <div class="col-sm-12">
                                        <div id="passwordHelp" class="form-text">
                                            A senha deve ter no mínimo 8 caracteres.
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-12">
                                        <label for="role" class="form-label">Função <code>*</code></label>
                                        <select class="select-userRole w-100" name="role">
                                            <?php
                                                $roles = \App\Models\Permission::all();
                                                foreach($roles as $role){
                                                    echo '<option value="'.$role->name.'">'.$role->label.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="ModalButtonAddNewUser btn btn-primary w-100" type="submit">Cadastrar Colaborador</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col">
                    <div class="card">
                        <div id="blockui-card-1" class="card-body">
                            <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                <thead>
                                    <tr>
                                        <th style="display: none;width:4%;"  class="text-center">#</th>
                                        <th style="width:70%">Colaborador</th>
                                        <th style="width:20%">Cadastrado</th>
                                        <th style="width:10%" class="text-center">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td style="display: none" class="text-center">{{$user->id}}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 @if($user->last_activity>= now()->subMinutes(5)) user-activity-online-table @endif">
                                                    <img src="{{photo_user($user->cover)}}" alt="" class="user-cover">
                                                    <span class="activity-indicator-table"></span>
                                                </div>
                                                <div>
                                                    <p class="m-0 text-black title-row-in-table">
                                                        {{$user->name}}
                                                    </p>
                                                    <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                        @foreach ($user->permissions as $permission)
                                                            {{$permission->label}}@if(!$loop->last), @endif
                                                        @endforeach
                                                    </p>
                                                </div>
                                                <div>
                                                    <a href="{{route('user.show', ['id' => $user->id])}}">
                                                        <i class="material-symbols-outlined text-gray ms-3" >bubble</i>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="m-0 text-black title-row-in-table">
                                                        {{date('d/m/Y', strtotime($user->created_at))}}
                                                    </p>
                                                    <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                        {{date('\á\s H:i', strtotime($user->created_at))}}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="div-form-check-active form-check form-switch">
                                                <input data-id="{{$user->id}}" class="form-check-input input-change-status-user" type="checkbox" {{$user->active==1?"checked":""}}>
                                            </div>
                                        </td>
                                    </tr>
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
