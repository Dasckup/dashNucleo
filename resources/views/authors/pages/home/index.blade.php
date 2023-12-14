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
        background: #f7f7f7;
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

    .list-materials{
        padding: 10px;
    }

    .material {
        width: 100%;
        background: #fff;
        border-radius: 3px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        padding: 15px;
    }
</style>
@endsection

@section('js')
<script src="{{asset("/template/assets/js/datatables.js")}}"></script>

    <script>
        $(document).ready(function() {
            $('#myMaterials').DataTable({
                "language": {
                    "sZeroRecords": "<?= __('messages.datatable.sZeroRecords') ?>",
                    "paginate": {
                        "next": ">",
                        "previous": "<"
                    },
                    "info": "<?= __('messages.datatable.showing') ?> _START_ <?= __('messages.datatable.to') ?> _END_ <?= __('messages.datatable.of') ?> _TOTAL_",
                    "sInfoEmpty": "<?= __('messages.datatable.showing') ?> 0 <?= __('messages.datatable.to') ?> 0 <?= __('messages.datatable.of') ?> 0",
                    "infoFiltered": "(<?= __('messages.datatable.filtered_from') ?> _MAX_)",
                    "decimal": ",",
                    "thousands": ".",
                    "lengthMenu": "<?= __('messages.datatable.showing') ?> _MENU_",
                    "search": "<?= __('messages.datatable.search') ?>:"
                },
                "order": [[0, "desc"]]
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
                        <div class="row">
                            <div class="proccess">
                                <div class="process-title bg-primary">🧐 Processo de Analise</div>
                                <div class="list-materials">
                                    <div class="material">
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <img width="45px" height="45px" src="{{asset('/template/assets/images/icons/pdf-icon.png')}}">
                                            </div>
                                            <div>
                                                <div class="text-black title-row-in-table">submitting article.pdf</div>
                                                <div class="sub-title-row-in-table">10.87 KB</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="material">
                                        <div class="d-flex">
                                            <div class="me-2">
                                                <img width="45px" height="45px" src="{{asset('/template/assets/images/icons/pdf-icon.png')}}">
                                            </div>
                                            <div>
                                                <div class="text-black title-row-in-table">submitting article.pdf</div>
                                                <div class="sub-title-row-in-table">10.87 KB</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="proccess">
                                <div class="process-title bg-primary">🔍 Processo de Antiplagio</div>
                                <div class="list-materials">
                                </div>
                            </div>
                            <div class="proccess">
                                <div class="process-title bg-primary">😁 Processo de Publicação</div>
                                <div class="list-materials">
                                </div>
                            </div>
                            <div class="proccess">
                                <div class="process-title bg-success">🥳 Publicados</div>
                                <div class="list-materials">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
