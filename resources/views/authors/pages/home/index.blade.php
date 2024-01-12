@extends('authors.main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

<style>
    .dataTables_filter label,
    .dataTables_length label,
    .dataTables_info{
        font-size: 12.7px!important;
        font-weight: 600!important;
        color: #717171!important;
    }

    .button-new-material{
        font-size: 12px;
        font-weight: 600;
        display: flex;
        width: fit-content;
        align-items: center;
    }

    .icon-new-material{
        font-size: 21px;
        margin-left: -11px;
    }

    .proccess{
        height: 600px;
        width: 300px;
        background: #f4f4f4;
        margin-right: 13px;
        border-radius: 3px;
        padding: 0px
    }

    .process-title{
        border-radius: 3px 3px 0px 0px;
        padding: 9px;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
    }

    .list-materials {
        padding: 10px;
    }

    .list-materials-row {
        overflow: auto;
        flex-wrap: nowrap!important;
        padding-bottom: 10px;
    }

    .list-materials-row::-webkit-scrollbar {
        height: 10px!important;
    }


    .material {
        width: 100%;
        background: #fff;
        border-radius: 3px;
        margin-bottom: 10px;
        display: flex;
        flex-direction: column;
        padding: 15px;
    }

    .material-title{
        font-size: 14px;
        font-weight: 600;
        margin-bottom: 3px;
    }

    .material-deadline{
        font-size: 11px;
        font-weight: 500;
    }

    .material-autor{
        font-size: 11px;
        font-weight: 500;
    }

    .material-file-title{
        font-size: 12px;
        font-weight: 600;
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
</style>
@endsection

@section('js')
<script src="{{asset("/template/assets/js/datatables.js")}}"></script>

<script>
        $(document).ready(function () {
        $(".list-materials-row").on('mousedown', function (event) {
            var startX = event.pageX;
            var startScrollLeft = $(this).scrollLeft();

            $(this).on('mousemove', function (event) {
                var moveX = startScrollLeft - (event.pageX - startX);

                $(this).scrollLeft(moveX);
            });

            $(document).on('mouseup', function () {
                $(".list-materials-row").off('mousemove');
                $(document).off('mouseup');
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
                    <div class="col-sm-12 ps-0">
                        <div class="page-description p-0 pt-4 pb-4">
                            <h1>{{__('messages.home.title_my_materials')}}</h1>
                            <span style="margin-top: 15px;">{{__('messages.home.subtitle_my_materials')}}</span>
                        </div>
                    </div>

                    <div class="col-sm-12 mb-3 p-0">
                        <a class="btn btn-primary button-new-material">
                            <span class="material-symbols-outlined icon-new-material">add</span>
                            Enviar outro material
                        </a>
                    </div>

                    <div class="col-sm-12">
                        <div class="row list-materials-row">
                            @foreach ($processes as $process)
                                <div class="proccess">
                                    <div class="process-title" style="background:{{$process->color}}">{{$process->label}}</div>
                                    <div class="list-materials">
                                        @foreach ($process->process_clients as $client)
                                        <div class="material">
                                            <div class="material-title d-flex aling-items-center">
                                                Processo #{{$client->id}} <a class="ms-2 link-icon-to-material" href="{{route('AppAuthor.material.show' ,  ["id" => $client->id])}}"><span class="material-symbols-outlined"> bubble </span></a>
                                            </div>
                                            <div class="material-deadline">
                                                Prazo: <b>19 dias úteis ({{date('d/m/Y', strtotime($client->created_at. ' + '.$client->deadline_amount.' '.$client->deadline_type))}})</b>
                                            </div>
                                            <div class="material-autor">
                                                Autor: {{$client->author->name}} {{$client->author->last_name}}
                                            </div>

                                            <div class="mt-3 material-file-displayed-title">
                                                Útima versão do artigo:
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2">
                                                        <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/pdf-icon.png')}}">
                                                    </div>
                                                    <div>
                                                        <div class="text-black material-file-title">submitting article.pdf</div>
                                                        <div class="material-file-size">10.87 KB</div>
                                                    </div>
                                                </div>
                                                <div class="material-file-download">
                                                    <a class="material-file-download-icon" href="#">
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
