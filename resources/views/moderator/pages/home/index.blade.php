@extends('editors.main._index')

@section('css')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        .status-conunt-badge{
            padding: 3px 5px 2px 5px!important;
            margin-left: 10px!important;
        }

        .nav-pills .nav-link-warning.active, .nav-pills .show>.nav-link-warning{
            background-color: #fbc62859!important
        }
        .nav-pills .nav-link-success.active, .nav-pills .show>.nav-link-success{
            background-color: #2db67640!important
        }
        .nav-pills .nav-link-danger.active, .nav-pills .show>.nav-link-danger{
            background-color: #f2081e30!important;
        }

        .badge-bg-warning{
            background-color: #fbc62859!important;
            color: var(--bs-warning)!important;
            border: 1px solid var(--bs-warning)!important;
        }
        .badge-bg-success{
            background-color: #2db67640!important;
            color: var(--bs-success)!important;
            border: 1px solid var(--bs-success)!important;
        }
        .badge-bg-danger{
            background-color: #f2081e30!important;;
            color: var(--bs-danger)!important;
            border: 1px solid var(--bs-danger)!important;
        }


        .material-title-process{
            font-size: 17px;
            font-weight: bold;
        }

        .material-deadline-process{
            font-size: 11px;
            font-weight: 600;
            color: #999;
        }


        .event-comment-material-name{
            font-size: 11px;
            font-weight: 500;
        }
        .event-comment-material-size{
            font-size: 10px;
        }

        .anyone-material-finded{
            display: flex;
            padding: 38px;
            font-size: 14px;
            align-items: center;
            font-weight: 500;
            color: #999;
            flex-direction: column;
        }

        .anyone-material-finded span{
            font-size: 32px;
            margin-top: 18px;
        }

        .process-table-label{
            font-size: 12px;
            font-weight: 500;
            color: #999;
        }
    </style>
@endsection

@section('js')
<script>
    function copyText(textToCopy) {
        var inputElement = document.createElement('input');
        inputElement.value = textToCopy;
        document.body.appendChild(inputElement);
        inputElement.select();
        inputElement.setSelectionRange(0, 99999);
        document.execCommand('copy');
        document.body.removeChild(inputElement);
    }
</script>
@endsection

@section('content')
<div class="app-content">
    <div class="content-wrapper">
        <div class="container">
            <div class="row pt-4">
                <div class="card card-body p-4">

                    <h2 class="fw-bold mb-4">Materiais</h2>

                    <div class="materials-list">
                        @foreach ($processes as $process)
                            @include('moderator.pages.home._process', ['process' => $process])
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@php
    function getAmountProcess($process) : int {
        if(isset($process) && $process){
            return count($process);
        }else{
            return 0;
        }
    }
@endphp

