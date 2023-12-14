@extends('authors.main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<style>
    input:disabled{
        background-color: #fff !important;
    }

    .proccess{
        min-width: 50px;
        min-height: 50px;
        border-radius: 50%;
        background-color: #E5E5E5;
        display: flex;
        justify-content: center;
        align-items: center;
        content: '';
    }

    .proccess:first-child::before{
        width: 0;
    }

    .proccess span{
        font-size: 30px;
        color: #999;
    }

    .proccess.active span{
        font-size: 30px;
        color: #fff;
    }

    .proccess.active{
        background-color: #0067ef;
    }

    .line-process{
        width: 100%;
        height: 5px;
        background-color: #E5E5E5;
        margin-bottom: 20px;
    }

    .proccess-list{
        display: flex;
        justify-content: space-between;
        margin-bottom: 25px;
        align-items: center;
    }

    .proccess-line {
        width: 100%;
        height: 10px;
        background-color: #E5E5E5;
    }

    .proccess-line.active{
        background-color: #0067ef;
    }

    .material-right .material-items .sub-title-row-in-table{
        display: flex;
        justify-content: flex-end;
    }
    .material-right{
        flex-direction: row-reverse;
    }
    .label-value-clients{
        font-weight: 600;
        font-size: 11px!important
    }
    .value-clients{
        font-weight: 500;
        font-size: 12px!important
    }




    .events-list{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .events {
        display: flex;
        padding: 0px 0px 5px 0px;
    }

    .event-icon {
        margin-right: 10px;
        background: #fff;
        padding: 7px 7px 0px;
        border-radius: 100%;
        margin-left: -15px;
        height: fit-content;
    }

    .event-icon span{
        font-size: 17px;
        color: #696969;
    }




    .event-content{
        display: flex;
        flex-direction: column;
        position: relative;
        background: #fff;
        padding: 20px;
        border-radius: 4px;
    }

    .event-content-date{
        font-size: 11px;
        color: #666;
        margin-bottom: 5px;
    }

    .event-content-note{
        font-size: 12px;
        color: #696969;
        max-width: 380px;
        margin-bottom: 10px
    }

    .event-check {
        position: absolute;
        top: 0px;
        right: 0px;
        z-index: 100;
        margin-right: 0px;
        margin-top: 9px;
    }

    .event-content-material{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
    }



    .event-content-note.check{
        text-decoration: line-through;
    }







    .radio-container {
    display: block;
    position: relative;
    padding-left: 30px; /* Ajuste conforme necessário */
    margin-bottom: 15px;
    cursor: pointer;
    font-size: 16px;
    }

    .radio-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    }



    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #eee;
        border: 1px solid #dfdfdf;
        border-radius: 100%;
    }

    .radio-container:hover input ~ .checkmark {
    background-color: #ddd; /* Cor de fundo ao passar o mouse */
    }

    .radio-container input:checked ~ .checkmark {
        background-color: #00c866;
    }

    .checkmark:after {
    content: "";
    position: absolute;
    display: none;
    }

    .radio-container input:checked ~ .checkmark:after {
    display: block;
    }

    .radio-container .checkmark:after {
        left: 6px;
        top: 3px;
        width: 6px;
        height: 10px;
        border: solid white;
        border-width: 0 2px 2px 0;
        transform: rotate(45deg);
    }


    .versions-material{
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .versions-material-date {
        font-size: 12px;
        margin: 20px -15px;
        font-weight: 500;
        display: flex;
        color: #666;
    }

    .versions-material-line{
        height: auto;
        width: 1px;
        background: #cecece;
    }

    .version-icon-material{
        margin-right: 10px;
        margin-left: -9px;
        background: #fff;
        font-size: 20px;
        color: #cecece;
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

    .events-note{
        font-size: 12px;
        font-weight: 500;
        max-width: 515px;
        padding-left: 10px;
    }

    .events-date{
        font-weight: 600;
    }

    .event-date{
        font-size: 11px;
        font-weight: 500;
        color: #a9a6a6;
        margin-top: 10px;
    }

    .footer-event-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: -8px;
    }


    .coments-event-button {
        font-size: 11px;
        color: #999;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }

    .comments-event-button{
        margin-top: 13px;
        margin-left: -24px;
    }

    .coments-reponse-event-button,
    .coments-like-event-button,
    .coment-event-button{
        font-size: 11px;
        color: #999;
        text-decoration: none;
        font-weight: 500;
        cursor: pointer;
        transition: color 0.2s ease-in-out;
        display: flex;
        align-items: center;
    }

    .coments-like-event-button:hover,
    .coments-reponse-event-button:hover,
    .coment-event-button{
        color: var(--bs-primary);
    }

    .coments-event-button span{
        font-size: 14px;
        margin-left: 3px;
    }

    .coments-event-button:hover{
        color: #696969;
    }



    .event-comments{
        padding-left: 25px;
    }

    .event-comment{
        font-size: 12px;
        font-weight: 500;
        max-width: 456px;
        border-radius: 0px 10px 10px 10px!important;
    }

    .event-comment-icon-user{
        margin-right: 10px;
    }

    .event-comment-material-name{
        font-size: 11px;
        font-weight: 500;
    }
    .event-comment-material-size{
        font-size: 10px;
    }

    .event-not-comments{
        width: 100%;
        text-align: center;
        font-size: 11px;
        color: #999;
        margin-top: 20px;
    }

    .coment-event-button{
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        margin-top: 15px
    }

    .coment-event-button span{
        font-size: 14px;
        margin-left: 3px;
    }
</style>
@endsection

@section('js')
<script>
    function showCommentsFrom(id){
        var ele = $('#comments-from-event-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function addCommentTo(id){
        var ele = $('#comment-to-event-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }

    function reponseToComment(id){
        var ele = $('#response-comment-to-'+id);
        if(!ele){
            return;
        }

        ele.slideToggle();
    }
</script>
@endsection

@section('content')

    <?php
        $extentions = explode('.', $material->url_material);
        $extention = end($extentions);

        $data = [
            [
                "id" => 11,
                "date" => "2023-12-13 12:30:50",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => [
                    [
                        "id" => 1,
                        "date" => "2023-12-13 12:30:50",
                        "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl.",
                        "material" => [
                            [
                                "name" => "Material 1.pdf",
                                "size" => "23KB",
                                "url" => "https://google.com.br",
                                "type" => "pdf"
                            ]
                        ],
                    ],
                    [
                        "id" => 2,
                        "date" => "2023-12-13 12:30:50",
                        "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl.",
                        "material" => [
                            [
                                "name" => "Material 1.pdf",
                                "size" => "23KB",
                                "url" => "https://google.com.br",
                                "type" => "pdf"
                            ],
                            [
                                "name" => "Material 1.docx",
                                "size" => "23KB",
                                "url" => "https://google.com.br",
                                "type" => "docx"
                            ]
                        ],
                    ],
                ]
            ],
            [
                "id" => 10,
                "date" => "2023-12-13 20:16:20",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 9,
                "date" => "2023-12-13 21:36:20",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 8,
                "date" => "2023-12-10 11:26:10",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 7,
                "date" => "2023-12-10 16:50:11",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 6,
                "date" => "2023-12-10 20:56:19",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 5,
                "date" => "2023-11-30 02:16:17",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 4,
                "date" => "2023-11-30 06:10:09",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 3,
                "date" => "2023-11-30 11:50:04",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 2,
                "date" => "2023-11-30 17:30:02",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ],
            [
                "id" => 1,
                "date" => "2023-11-30 18:00:23",
                "note" => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl. Sed euismod, diam quis aliquam tincidunt, nunc nisl ultrices nunc, quis aliquam nisl nisl eu nisl.",
                "check" => false,
                "material" => [
                    "name" => "Material 1.pdf",
                    "url" => "https://google.com.br",
                    "type" => "pdf"
                ],
                "comments" => []
            ]
        ]
    ?>

    <div class="app-content pt-5">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">

                                <div class="col-sm-12 pt-3">
                                    <div class="row mb-4">
                                        <div class="col-sm-12 mb-3">
                                            <div class="label-value-clients mb-1">Status</div>
                                            <div class="value-clients">
                                                Processo de Análise
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="label-value-clients mb-1">Prazo limite para análise</div>
                                            <div class="value-clients">
                                                19 dias úteis
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mb-3">
                                            <div class="label-value-clients mb-1">Data termino de análise</div>
                                            <div class="value-clients">
                                                02/01/2024 ás 23:59
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 mb-3">
                                        <div class="label-value-clients mb-1">Nome</div>
                                        <div class="value-clients">
                                            {{$material->clients->name}} {{$material->clients->last_name}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-3">
                                        <div class="label-value-clients mb-1">E-mail</div>
                                        <div class="value-clients">
                                            {{$material->clients->email}}
                                        </div>
                                    </div>
                                    <div class="col-sm-12 mb-5">
                                        <div class="label-value-clients mb-1">Número de celular</div>
                                        <div class="value-clients">
                                            {{$material->clients->ddi}} {{$material->clients->cellphone}}
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex ps-5 pt-0 card-body">
                        <div class="events-list">

                            @php
                                function groupByDate($array) {
                                    $result = [];
                                    foreach ($array as $item) {
                                        $date = date('Y-m-d', strtotime($item['date']));
                                        if(date('d/m/Y', strtotime($item['date']))==date('d/m/Y')){
                                            $date = 'Hoje';
                                        }

                                        $result[$date][] = $item;
                                    }
                                    return $result;
                                }

                                $groupedData = groupByDate($data);
                            @endphp
                            <div class="col-sm-12">

                            @foreach ($groupedData as $date => $group)
                                <div class="events">

                                    @if($date!=="Hoje")
                                    <div class="events-line position-relative">
                                        <span class="event-line-icon-top material-symbols-outlined">
                                            trip_origin
                                        </span>
                                        <div class="events-line-background"></div>
                                        <span class="event-line-icon-bottom material-symbols-outlined">
                                            trip_origin
                                        </span>
                                    </div>
                                    @endif

                                    <div class="d-flex flex-column" style="padding-left: 20px;">
                                        <div class="events-date mb-3"><?php echo $date === "Hoje" ? $date : \Carbon\Carbon::parse($date)->isoFormat('D ['.__('messages.datatable.of').'] MMMM ['.__('messages.datatable.of').'] YYYY') ?></div>
                                        @foreach ($group as $key => $item)
                                            <div class="card event-content card-body event">
                                                <div class="d-flex">
                                                    <div class="text-success" style=" padding-top: 5px;">
                                                        <span class="material-symbols-outlined">
                                                            for_you
                                                        </span>
                                                    </div>
                                                    <div class="events-note">
                                                        {{ $item['note'] }}
                                                    </div>
                                                </div>
                                                <div class="footer-event-content mt-3">
                                                    <div class="coments-event-footer">
                                                        <a onclick="showCommentsFrom('<?= $item['id'] ?>')" class="coments-event-button">
                                                            Comentarios
                                                            <span class="material-symbols-outlined">expand_more</span>
                                                        </a>
                                                    </div>
                                                    <div class="event-date">
                                                        {{date('d/m/Y \á\s H:i', strtotime($item['date']))}}
                                                    </div>
                                                </div>

                                                <div style="display:none" class="event-comments" id="comments-from-event-{{$item['id']}}">
                                                    <a onclick="addCommentTo('<?= $item['id'] ?>')" class="coment-event-button"><span class="material-symbols-outlined">add</span> Adicionar Comentário</a>

                                                    <ul style="list-style:none;display:none" id="comment-to-event-{{$item["id"]}}" class="m-0 mb-5 p-0">
                                                        <li class="d-flex">
                                                            <div class="h-100 event-comment-icon-user">
                                                                <span class="material-symbols-outlined">
                                                                    account_circle
                                                                </span>
                                                            </div>
                                                            <div class="w-100" style="max-width: 456px">
                                                                <textarea style="border-radius: 0px 10px 10px 10px" name="" id="" cols="30" rows="3" class="form-control mb-2"></textarea>
                                                                <input type="file" name="" id="" class="form-control mb-2">
                                                                <div class="d-flex justify-content-end">
                                                                    <button style="font-size: 11px;font-weight:600" type="submit" class="btn btn-primary p-2">comentar</button>
                                                                </div>
                                                            </div>
                                                        </li>
                                                    </ul>

                                                    <ul style="list-style:none;" class="m-0 p-0">
                                                        @if(count($item["comments"])>0)
                                                            @foreach ($item['comments'] as $comment)
                                                                <li class="d-flex flex-column">
                                                                    <div class="d-flex">
                                                                        <div class="h-100 event-comment-icon-user">
                                                                            <span class="material-symbols-outlined">
                                                                                account_circle
                                                                            </span>
                                                                        </div>
                                                                        <div class="event-comment card p-3">
                                                                            <div class="mb-3">
                                                                                {{$comment['note']}}
                                                                            </div>

                                                                            @foreach ($comment["material"] as $material)
                                                                                <div class="d-flex align-items-center mb-2">
                                                                                    <div>
                                                                                        <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/'.$material['type'].'-icon.png')}}">
                                                                                    </div>
                                                                                    <div class="ms-3 d-flex flex-column">
                                                                                        <div class="text-black event-comment-material-name">{{$material['name']}}</div>
                                                                                        <div class="event-comment-material-size">{{$material['size']}}</div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach

                                                                            <div class="d-flex mt-3">
                                                                                <a onclick="reponseToComment('<?= $comment['id'] ?>')" class="coments-reponse-event-button me-3 ">
                                                                                    Responder
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div id="response-comment-to-{{$comment['id']}}" style="padding-left: 30px;display:none">
                                                                        <div class="d-flex mb-4">
                                                                            <div class="h-100 event-comment-icon-user">
                                                                                <span class="material-symbols-outlined">
                                                                                    account_circle
                                                                                </span>
                                                                            </div>
                                                                            <div class="w-100" style="max-width: 456px">
                                                                                <textarea style="border-radius: 0px 10px 10px 10px" name="" id="" cols="30" rows="3" class="form-control mb-2"></textarea>
                                                                                <input type="file" name="" id="" class="form-control mb-2">
                                                                                <div class="d-flex justify-content-end">
                                                                                    <button style="font-size: 11px;font-weight:600" type="submit" class="btn btn-primary p-2">comentar</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <div class="event-not-comments">
                                                                Nenhum comentário
                                                            </div>
                                                        @endif
                                                    </ul>
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
    </div>
@endsection
