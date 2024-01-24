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


       $('form[name="formSaveUser"]').on('submit', function (event) {
            event.preventDefault();

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
                            message: `${form.target.name.value} foi cadastrado com sucesso!`,
                        });

                        window.location.reload();
                    }
                },
                error: (err) => {
                    console.error(err);
                }
            })
       })
    });


</script>
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="p-0 pt-2 page-description page-description-tabbed">
                        <h1>Colaboradores</h1>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 mb-3">
                <a class="ModalButtonAddNewUser btn btn-primary p-2" data-bs-toggle="modal" data-bs-target="#ModalAddNewUser">Novo Colaborador</a>
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
                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="name" class="form-label">Nome <code>*</code></label>
                                        <input type="text" class="form-control" name="name" id="name" />
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <label for="email" class="form-label">E-mail <code>*</code></label>
                                        <input autocomplete="off" type="text" class="form-control" name="email" id="email" />
                                    </div>
                                </div>

                                <div class="row mb-4">
                                    <div class="col-sm-6">
                                        <label for="password" class="form-label">Senha <code>*</code></label>
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
                                                    <img src="{{$user->cover}}" alt="" class="user-cover">
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
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
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
