@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
    .dropdown-item{
        cursor: pointer;
    }

    .alert-custom{
        margin-bottom: 15px;
    }

    .text-pink {
        color: var(--bs-pink)!important;
    }
    .border-pink{
        border-color: var(--bs-pink)!important;
    }

    .text-gray {
        color: var(--bs-gray)!important;
    }
    .border-gray{
        border-color: var(--bs-gray)!important;
    }
    .text-red-light {
        color: #e3504b!important;
    }
    .border-red-light{
        border-color: #e3504b!important;
    }
    .link-to-open-submition i{
        font-size: 25px;
        margin-left: 12px;
    }

    .dropdown-button-choose-status{
        font-size: 13px;
        text-transform: uppercase;
        font-weight: 600
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
    a{
        text-decoration: none!important;
    }
    .header-button-on-table{
        width: fit-content;
        font-size: 12px;
        font-weight: 600;
        padding: 5px;
    }

    .app-menu>ul>li ul li a {
        padding: 5px 20px;
        font-size: 12px;
    }

    .app-menu>ul>li ul {
        padding: 10px 0;
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
    </style>
@endsection

@section('js')
    <script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
    <script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>

<script>
    // =
</script>
@endsection


@section('content')
    <div class="app-content">
        <div class="content-wrapper">

            <div class="row">
                <div class="col">
                    <div class="page-description pt-2 ps-0 pb-0 border-0">
                        <h1 class="text-captalize">Autores</h1>
                        <span style="margin-top: 10px;">Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                    </div>
                </div>
            </div>


            <div class="card card-body">
                <div id="blockui-card-1" class="card-body">
                    <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Autor</th>
                                <th>Artigos</th>
                                <th>Data</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($authors as $author)
                            <?php
                                $name = explode(' ', mb_convert_case($author->name, MB_CASE_TITLE, "UTF-8"))[0];
                            ?>
                            <tr id="author-{{$author->id}}">
                                <td class="text-center" >
                                    <div style="height:39px!important" class="d-flex align-items-center justify-content-center">
                                        {{$author->id}}
                                    </div>
                                </td>
                                <td style=" padding: 13px 20px!important; ">
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="m-0 d-flex  text-black title-row-in-table">
                                                {{$author->name}} {{$author->last_name}}
                                            </p>
                                            @if($author->description)
                                                <p style="font-weight:500" class="m-0 sub-title-row-in-table">
                                                    @if($author->description->find_us!=="outro")
                                                        {{$author->description->find_us}}
                                                    @else
                                                        {{$author->description->outer_find_us}}
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                        <div>
                                            <a class="link-to-open-submition" href="{{route("author.show", ["id"=>$author->id])}}">
                                                <i class="material-symbols-outlined text-gray" >bubble</i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <ul class="d-flex p-0 m-0 mt-2" style="list-style: none">
                                            <li class="me-2">
                                                <a target="_blank" href="{{route("author.show", ["id"=>$author->id])}}#material">
                                                    <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                                        <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                                            description
                                                        </span>
                                                        <span>{{count($author->files)}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li class="me-2">
                                                <a target="_blank" href="{{route("author.show", ["id"=>$author->id])}}#notes">
                                                    <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                                        <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                                            note_stack
                                                        </span>
                                                        <span>{{count($author->notes)}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                            <li>
                                                <a target="_blank" href="{{route("author.show", ["id"=>$author->id])}}#submissions">
                                                    <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                                        <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                                            shopping_bag
                                                        </span>
                                                        <span>{{count($author->article)}}</span>
                                                    </span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="m-0 text-black title-row-in-table d-flex">
                                                @php
                                                    $isValidEmail = preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $author->email);
                                                    $emailIconColor = $isValidEmail ? '' : 'text-grey';
                                                    $emailHref = $isValidEmail ? 'mailto:'.$author->email : 'javascript:void(0)';
                                                @endphp
                                                <a class="d-flex align-items-center me-2" style="text-decoration: none" href="{{$emailHref}}">
                                                    <i style="font-size: 15px;" class="material-icons m-0 {{$emailIconColor}}">forward_to_inbox</i>
                                                </a>
                                                <span>{{$author->email}}</span>
                                            </p>
                                            <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex">
                                                @php
                                                    $isValidCellphone = preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $author->cellphone);
                                                    $whatsappIconColor = $isValidCellphone ? '' : 'text-grey';
                                                    $whatsappHref = $isValidCellphone ? 'https://web.whatsapp.com/send/?phone='.str_replace('+', '', $author->ddi).preg_replace('/[^0-9]/', '', $author->cellphone).'&text=Ol%C3%A1+'.$name.'%2C+tudo+bem%3F&type=phone_number' : 'javascript:void(0)';
                                                @endphp
                                                <a target="_BLANK" class="d-flex align-items-center me-1" style="text-decoration: none" href="{{$whatsappHref}}">
                                                    <span style="font-size: 15px;" class="material-symbols-outlined m-0 {{$whatsappIconColor}}">
                                                        quick_phrases
                                                    </span>
                                                </a>
                                                <span>{{$author->ddi}} {{$author->cellphone}}</span>
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <p class="m-0 text-black title-row-in-table">{{date("d/m/Y", strtotime($author->created_at))}}</p>
                                            <p style="font-weight:500" class="m-0 sub-title-row-in-table">{{date("\á\s H:i", strtotime($author->created_at))}}</p>
                                        </div>
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

@endsection
