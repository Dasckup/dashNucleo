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

    .badge-reason-cancelation{
            padding: 4px!important;
            margin-left: 4px;
            border-color: red!important;
            color: red!important;
    }
</style>
@endsection

@section('js')
    <script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
    <script src="{{custom_asset("/template/assets/js/blockui.js")}}"></script>

    <script>
        async function updateTerm(client, status) {
            try {
                const result = await $.ajax({
                    url: "{{route('client.consult.term')}}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "user": "{{Auth::user() ? Auth::user()->id : ''}}",
                        "id": client
                    },
                });

                if (!result.client.term) {
                    $('#blockui-card-1').unblock();
                    $('#ModalSelecionarPrazo').modal('show');
                    $("form[name='formNewPrazo'] #client").val(client);
                    $("form[name='formNewPrazo'] #status").val(status);
                    $('#author-name-prazo').html(result.client.name);
                    return false;
                } else {
                    return true;
                }
            } catch (error) {
                console.error("Erro na requisição AJAX:", error);
                return false;
            }
        }

        function updateToCanceled(client){
            const clientName = $("#client-"+client+" .title-row-in-table").html();
            $('#blockui-card-1').unblock();
            $('#ModalUpdateToCanceled').modal('show');
            $("form[name='formUpdateToCanceled'] #client").val(client);
            $("form[name='formUpdateToCanceled'] #status").val(status);
            $("form[name='formUpdateToCanceled'] #author-name").html(clientName);
            $("form[name='formUpdateToCanceled'] #author-name-checkbox").html(clientName);
            $("form[name='formUpdateToCanceled'] #id-submission").html(client);
        }

        async function statusUpdate(element){
            $('#blockui-card-1').block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            const status = element.target.getAttribute('data-value');
            const client = element.target.getAttribute('data-to');
            const slug = element.target.getAttribute('data-slug');

            switch(slug){
                case "pagamento_pendentes":
                case "pagas":
                    if (!(await updateTerm(client, status))) {
                        return false;
                    }
                    break;
                case "cancelados":
                    updateToCanceled(client, status)
                    return true;
            }

            $.ajax({
                url: "{{route('client.update.status')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user": "{{Auth::user()->id}}",
                    "status": status,
                    "id": client
                },
                success: (data) => {
                    $("#client-"+client).remove();
                    showCustomToast("success", {
                        title: "Status da submissão atualizado com sucesso",
                        message: `A submissão foi movida para aba de submissões ${data.status}`,
                    });
                    $('#blockui-card-1').unblock();
                },
                error: (data) => {
                    showCustomToast("danger", {
                        title: "Erro ao atualizar status da submissão",
                        message: `A submissão não foi movida para aba de submissões ${data.status.status}`,
                    });
                    $('#blockui-card-1').unblock();
                }
            })
        }


        $(".dropdown-item-select-status-client").on("click" , function (event) {
            statusUpdate(event);
        })


        $("form[name='formNewPrazo']").on('submit', function (e) {
           e.preventDefault();

            $('#ModalSelecionarPrazo').block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });

            const status = e.target.status.value;
            const client = e.target.client.value;
            const term = e.target.prazo.value;
            const currency = e.target.currency.value;

            $.ajax({
                url: "{{route('client.update.submission')}}",
                method: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "user": "{{Auth::user()->id}}",
                    "status": status,
                    "id": client,
                    "term": term,
                    "currency": currency
                },
                success: (data) => {
                    $("#client-"+client).remove();
                    showCustomToast("success", {
                        title: "Status da submissão atualizado com sucesso",
                        message: `A submissão foi movida para aba de submissões ${data.status}`,
                    });
                    $('#ModalSelecionarPrazo').unblock();
                    $('#ModalSelecionarPrazo').modal('hide');
                },
                error: (data) => {
                    showCustomToast("danger", {
                        title: "Erro ao atualizar status da submissão",
                        message: `A submissão não foi movida`,
                    });
                    $('#ModalSelecionarPrazo').unblock();
                }
            })
        })



        $("form[name='formUpdateToCanceled']").on('submit', function (event) {
            event.preventDefault();

            $('#ModalUpdateToCanceled').block({
                message: '<div class="spinner-grow text-primary" role="status"><span class="visually-hidden">Loading...</span><div>',
            });
            const button = $(this).find("button[type='submit']");
            button.prop("disabled", true);
            button.text("Cancelando Submissão...");

            const form = event.target;

            function showError(element, message) {
                showCustomToast("danger", {
                    title: "Erro ao cancelar submissão",
                    message: message,
                });
                element.focus();
                element.classList.add('is-invalid');
                $('#ModalUpdateToCanceled').unblock();
                button.prop("disabled", false);
                button.html("Continuar com o cancelamento");
            }

            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            if (!form.confirmation.checked) {
                showError(form.confirmation, "Você precisa confirmar o cancelamento da submissão");
                return false;
            }

            if (form.observation.value.length < 10) {
                showError(form.observation, "Você precisa descrever o motivo do cancelamento da submissão");
                return false;
            }

            if (form.reason.value === "Selecione") {
                showError(form.reason, "Você precisa selecionar um motivo para o cancelamento da submissão");
                return false;
            }

            const formData = new FormData(form);
            formData.append("user", "{{Auth::user()->id}}");
            formData.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{route('client.update.canceled')}}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: (data) => {
                    $("#client-"+form.client.value).remove();
                    showCustomToast("success", {
                        title: "Submissão cancelada com sucesso",
                        message: `A submissão foi movida para aba de submissões canceladas`,
                    });
                    $('#ModalUpdateToCanceled').unblock();
                    $('#ModalUpdateToCanceled').modal('hide');
                    button.prop("disabled", false);
                    button.html("Continuar com o cancelamento");
                    form.reset();
                },
                error: (data) => {
                    showCustomToast("danger", {
                        title: "Erro ao cancelar submissão",
                        message: `A submissão não foi cancelada`,
                    });
                    $('#ModalUpdateToCanceled').unblock();
                    button.prop("disabled", false);
                    button.html("Continuar com o cancelamento");
                }
            })

        })

    </script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">



                <div class="row">
                    <div class="col">
                        <div class="page-description pt-2 ps-0 pb-0 border-0">
                            <h1 style="color: {{$status->color}}" class="text-captalize"><?=$status->name?></h1>
                            <span style="margin-top: 10px;">Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="display-alert" class="col-sm-12">
                    </div>
                </div>



                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div id="blockui-card-1" class="card-body">
                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:4%;" class="text-center">#</th>
                                            <th style="width:4%" class="text-center">Status</th>
                                            <th style="width:25%">Autor</th>
                                            <th style="width:19%">Prazo</th>
                                            <th style="width:25%">Contatos</th>
                                            <th style="width:15%" >Data</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($articles as $article)
                                            <?php
                                              $client = $article->material->clients;
                                              $name = explode(' ', mb_convert_case($client->name, MB_CASE_TITLE, "UTF-8"))[0];
                                              $email = $client->email ?? "Não informado";
                                              $submission = $client->submission;
                                            ?>
                                        <tr id="client-{{$article->material->id}}">
                                            <td class="text-center" >
                                                <div style="height:39px!important" class="d-flex align-items-center justify-content-center">
                                                    {{$article->material->id}}
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a
                                                       style="
                                                        color: {{$article->statusDetails->color}};
                                                        border-color: {{$article->statusDetails->color}};
                                                       "
                                                       class="btn border-2 dropdown-button-choose-status bg-transparent  text-@if($client->status){{$client->status->bs}}@endif border-@if($client->status){{$client->status->bs}}@endif dropdown-toggle"
                                                       href="#"
                                                       role="button"
                                                       id="dropdownMenuLink"
                                                       data-bs-toggle="dropdown"
                                                       aria-expanded="false"
                                                    >
                                                        {{$article->statusDetails->slug}}
                                                    </a>

                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        @foreach (\App\Models\Status::where("slug", "!=", $article->statusDetails->slug)->orderBy("order", "asc")->get() as $status)
                                                            <li>
                                                                <a class="dropdown-item  dropdown-item-select-status-client d-flex align-items-center" style="color:{{ $status->color }}" data-slug="{{ $status->route }}" data-value="{{ $status->id }}" data-to="{{ $article->material->id }}">
                                                                    <i class="material-icons me-2" style="font-size: 19px">{{ $status->icon }}</i> {{ $status->name }}
                                                                </a>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </td>
                                            <td style=" padding: 13px 20px!important; ">
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 d-flex  text-black title-row-in-table">
                                                            {{$client->name}} {{$client->last_name}}
                                                            <a target="_blank" href="{{route("client.show", ["id"=>$article->material->id])}}#documentation">
                                                                <?=getIconStatusDocument($client->document, [
                                                                    "components" => "",
                                                                    "class" => "",
                                                                    "style" => "font-size: 20px;"
                                                                ])?>
                                                            </a>
                                                        </p>

                                                        @if($client->submission)
                                                            <p style="font-weight:500" class="m-0 sub-title-row-in-table">
                                                                @if($client->submission->find_us!=="outro")
                                                                    {{$client->submission->find_us}}
                                                                @else
                                                                    {{$client->submission->outer_find_us}}
                                                                @endif
                                                            </p>
                                                        @endif
                                                        <div class="w-100">
                                                            <ul class="d-flex p-0 m-0 mt-2" style="list-style: none">
                                                                <li class="me-2">
                                                                    <a target="_blank" href="{{route("client.show", ["id"=>$article->material->id])}}#material">
                                                                        <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                                                            <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                                                                description
                                                                            </span>
                                                                            <span>{{$article->files_count}}</span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a target="_blank" href="{{route("client.show", ["id"=>$article->material->id])}}#notes">
                                                                        <span class="badge-count-information-submitions badge badge-style-bordered rounded-pill">
                                                                            <span style="font-size: 12px" class="material-symbols-outlined me-1">
                                                                                note_stack
                                                                            </span>
                                                                            <span>{{$article->notes_count}}</span>
                                                                        </span>
                                                                    </a>
                                                                </li>
                                                                @if($article->reasonCancellation)
                                                                <li>
                                                                    <span class="badge-count-information-submitions badge-reason-cancelation badge badge-style-bordered rounded-pill">
                                                                        <span>Motivo: {{$article->reasonCancellation->reasons->label}}</span>
                                                                    </span>
                                                                </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a class="link-to-open-submition" href="{{route("client.show", ["id"=>$article->material->id])}}">
                                                            <i class="material-symbols-outlined text-gray" >bubble</i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                            @if($client->submission)
                                                @php
                                                    $submission = $client->submission;
                                                    $title = $submission->term_publication_title ?: 'Nenhum prazo definido';
                                                    $price = $submission->term_publication_price ?: '0.00';
                                                    $isBRL = str_contains($price, "BRL");
                                                @endphp
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">{{$title}}</p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex align-items-center">
                                                            @unless($isBRL)
                                                                <i title="internacional" class="material-icons text-gray" style="font-size: 16px; margin-right:4px">public</i>
                                                            @endunless
                                                            @if($isBRL)
                                                                {{$price}}
                                                            @else
                                                                @php
                                                                    $amount = preg_replace('/[^\d.,]/', '', $price);
                                                                    $currencyCode = preg_replace('/[^a-zA-Z]/', '', $price);
                                                                @endphp
                                                                {{formatCurrency($amount, $currencyCode)}}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table d-flex">
                                                            @php
                                                                $isValidEmail = preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $client->email);
                                                                $emailIconColor = $isValidEmail ? '' : 'text-grey';
                                                                $emailHref = $isValidEmail ? 'mailto:'.$client->email : 'javascript:void(0)';
                                                            @endphp
                                                            <a class="d-flex align-items-center me-2" style="text-decoration: none" href="{{$emailHref}}">
                                                                <i style="font-size: 15px;" class="material-icons m-0 {{$emailIconColor}}">forward_to_inbox</i>
                                                            </a>
                                                            <span>{{$client->email}}</span>
                                                        </p>

                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table d-flex">
                                                            @php
                                                                $isValidCellphone = preg_match("/^\(\d{2}\) \d{5}-\d{4}$/", $client->cellphone);
                                                                $whatsappIconColor = $isValidCellphone ? '' : 'text-grey';
                                                                $whatsappHref = $isValidCellphone ? 'https://web.whatsapp.com/send/?phone='.str_replace('+', '', $client->ddi).preg_replace('/[^0-9]/', '', $client->cellphone).'&text=Ol%C3%A1+'.$name.'%2C+tudo+bem%3F&type=phone_number' : 'javascript:void(0)';
                                                            @endphp
                                                            <a target="_BLANK" class="d-flex align-items-center me-1" style="text-decoration: none" href="{{$whatsappHref}}">
                                                                <span style="font-size: 15px;" class="material-symbols-outlined m-0 {{$whatsappIconColor}}">
                                                                    quick_phrases
                                                                </span>
                                                            </a>
                                                            <span>{{$client->ddi}} {{$client->cellphone}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div>
                                                        <p class="m-0 text-black title-row-in-table">{{date("d/m/Y", strtotime($client->created_at))}}</p>
                                                        <p style="font-weight:500" class="m-0 sub-title-row-in-table">{{date("\á\s H:i", strtotime($client->created_at))}}</p>
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
        </div>
    </div>


    @include('pages.client.modals._index')
@endsection

