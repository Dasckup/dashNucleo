@extends('main._index')

@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
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

        .log-item{
            font-size: 13px;
            padding: 6px 0px 6px 0px;
            font-weight: 500;
        }

        .log-item-date{
            font-size: 11px;
            color: #999;
        }

        .log-item-messages span {
            font-size: 14px;
        }

        .progress-bar {
        width: 200px;
        height: 6px;
        background-color: #f0f0f0;
        border-radius: 4px;
        overflow: hidden;
        }

        .indeterminate-progress-success {
        width: 100%;
        height: 100%;
        background-color: var(--bs-primary);
        animation: progressAnimation 1.5s ease-in-out infinite;
        }

        .indeterminate-progress-stoped {
            height: 100%;
            width: 30%;
            background-color: #999;
        }

        @keyframes progressAnimation {
            0% {
                margin-left: -100%;
                margin-right: 100%;
            }
            50% {
                margin-left: 100%;
                margin-right: -100%;
            }
            100% {
                margin-left: 100%;
                margin-right: -100%;
            }
        }

        .icon-person{

            right: 0px;
            top: -10px;

        }

        .icon-robot{
            top: -10px;
        }

        .icon-stoped{
            left: 47%;
            top: -8px;
            color: var(--bs-danger);
        }

        .icon-stoped span{
            font-size: 36px;
            background: #fff;
            border-radius: 100%;
        }

        .message-text:not(.message-show-all) {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            max-width: 400px;
        }
    </style>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {
        $('.select-date').select2();
        $('.select-date').val('<?= $event->on_date ?>').trigger('change');

        $("select[name='send_on_date']").on('change', (e) => {
                const value = e.target.value;
                if(value == 'days'){
                    $('#display_actions_checkbox_date').removeClass('d-none');
                }else{
                    $('#display_actions_checkbox_date').addClass('d-none');
                }

                if(value == 'hours'){
                    $('#on_time_to_send').addClass('d-none');
                    $('#hours_selected').removeClass('d-none');
                }else{
                    $('#hours_selected').addClass('d-none');
                    $('#on_time_to_send').removeClass('d-none');
                }
            })


            $('#infinit-mode').on('click', () => {
                const input = $('#infinit-mode input');

                if(input.is(':checked')){
                    $('#set-limit').addClass('d-none');
                }else{
                    $('#set-limit').removeClass('d-none');
                }
            })

        $("#on_time_to_send").on('click', (e) => {

            const input = $('#on_time_to_send input');
            if(input.is(':checked')){
                $('#select_time_to_send').removeClass('d-none');
            }else{
                $('#select_time_to_send').addClass('d-none');
            }
        })
        $("#comercial_time").on('click', () => {
            const input = $("input[name='comercial_time']");
            const selectHorarioComercial = $('#select_horario_comercial');

            if(input.is(':checked')){
                selectHorarioComercial.removeClass('d-none');
            }else{
                selectHorarioComercial.addClass('d-none');
            }
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

                    <div class="page-description">
                        <h1 class="d-flex align-items-center"> Editar evento </h1>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-custom position-relative" role="alert">
                            <div class="position-absolute me-2" style="right:0px">
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <div class="custom-alert-icon icon-success"><i class="material-icons-outlined">done</i></div>
                            <div class="alert-content">
                                <span class="alert-title">Evento editado com sucesso!</span>
                                <span class="alert-text">As alterações entraram em vigor a partir do próximo ciclo</span>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-custom" role="alert">
                            <div class="custom-alert-icon icon-danger"><i class="material-icons-outlined">close</i></div>
                            <div class="alert-content">
                                <span class="alert-title">Não foi possivel editar o evento...</span>
                                <span class="alert-text">Algo deu errado, tente novamente mais tarde e/ou consulte o suporte técnico</span>
                            </div>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-sm-7">
                            <div class="card">
                                <div class="card-body">
                                    <form method="POST" action="{{route('events.update', ['event' => $event->id])}}">
                                        @csrf
                                        @method('PUT')
                                        <div class="col-sm-12 mb-4 mt-3 position-relative">
                                            <div class="position-absolute icon-robot">
                                                <span style=" font-size: 36px; color: #0067ef; " class="material-symbols-outlined">
                                                smart_toy
                                                </span>
                                            </div>
                                            <div class="w-100" style=" padding: 7px 60px;">
                                                <div class="progress-bar w-100">
                                                    <div class="indeterminate-progress-{{!$event->active?"stoped":"success"}}"></div>
                                                </div>
                                            </div>
                                            <div class="position-absolute icon-person">
                                                <span style=" font-size: 36px;  " class="text-{{!$event->active?"danger":"primary"}} material-symbols-outlined">
                                                    face
                                                </span>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mb-3">
                                            <label class="form-label">Enviar para:</label>
                                            <h4 style=" font-weight: bold; ">
                                                Pendentes
                                            </h4>
                                        </div>
                                        <br />
                                        <div class="col-sm-12 mb-3 ">
                                            <label class="form-label">Mensagem <code>*</code></label>
                                            <textarea name="message" id="" cols="30" rows="10" class="form-control">{{$event->message}}</textarea>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-12">
                                                <label for="settingsInputFirstName" class="form-label">Enviar a cada: <code>*</code></label>
                                            </div>
                                            <div class="col-md-6">
                                                <input value="<?= $event->on_date_amount ?>" name="send_on_date_amount" placeholder="Exemplo: 3" type="number" min="1" max="100" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <select class="select-date w-100" name="send_on_date">
                                                    <option value="days">Dias</option>
                                                    <option value="hours">Horas</option>
                                                    <option value="weeks">Semanas</option>
                                                    <option value="months">Meses</option>
                                                    <option value="yers">Anos</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div id="display_actions_checkbox_date">
                                            <div class="row mt-4">
                                                <label  class="form-label" style=" line-height: 21px; ">
                                                    <input name="only_bussines_days" type="checkbox" class="form-check-input me-2"> Apenas dias úteis
                                                </label>
                                            </div>
                                        </div>

                                        <div id="field_select_time_to_send">
                                            <div class="col-sm-12">
                                                <label id="on_time_to_send" class="form-label" style=" line-height: 21px; ">
                                                    <input name="on_time_to_send" type="checkbox" class="form-check-input me-2"> Definir horario padrão
                                                </label>
                                            </div>
                                            <div id="select_time_to_send" class="col-sm-3 d-none">
                                                <label class="form-label">Horario <code>*</code></label>
                                                <input value="09:00" name="time_to_send" type="time" class="form-control">
                                            </div>
                                        </div>

                                        <div class="row d-none mt-4" id="hours_selected">
                                            <label id="comercial_time" class="form-label d-flex aling-items-center mt-1" style=" line-height: 21px; ">
                                                <input name="comercial_time" type="checkbox" class="form-check-input me-2"> Apenas Horario comercial
                                            </label>

                                            <div class="d-none" id="select_horario_comercial">
                                                <div class="row">
                                                    <div class="col-sm-3">
                                                        <input value="09:00" name="horario_comercial_de" placeholder="de" type="time" class="form-control">
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <input value="18:00" name="horario_comercial_ate" placeholder="até" type="time" class="form-control">
                                                    </div>
                                                    <div id="settingsEmailHelp" class="form-text">Horario limite para o disparo do evento</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-4">
                                            <div class="col-sm-12 mb-1">
                                                <label id="infinit-mode" class="form-label d-flex aling-items-center" style=" line-height: 21px; "><input name="infinit_mode" checked type="checkbox" class="form-check-input me-2"> Ciclo infinito</label>
                                            </div>

                                            <div class="d-none w-100" id="set-limit">
                                                <div class="row mt-1 w-100">
                                                    <div class="col-md-6">
                                                        <label for="settingsInputFirstName" class="form-label">Limite de ciclos: <code>*</code></label>
                                                        <input name="limit_ciclo" placeholder="Exemplo: 3" type="number" min="1" max="100" class="form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-sm-12 mt-5">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="card">
                                <div class="card-body">

                                    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="pills-events-tab" data-bs-toggle="pill" data-bs-target="#pills-events" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Historico de eventos</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="pills-updated-tab" data-bs-toggle="pill" data-bs-target="#pills-updated" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Historico de atualizações</button>
                                        </li>
                                    </ul>

                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade active show" id="pills-events" role="tabpanel" aria-labelledby="pills-events-tab">


                                            @if(isset($event->log))
                                                <div class="col-sm-12 d-flex flex-row">
                                                    <ul style="list-style:none;overflow:auto;max-height:600px" class="w-100 p-0 m-0">
                                                        @foreach ($event->log as $key => $log)
                                                            <li class="log-item d-flex flex-row">
                                                                <div class="d-flex align-items-center me-2">
                                                                    @if($log->success)
                                                                        <span class="text-success material-symbols-outlined">check_circle</span>
                                                                    @else
                                                                        <span class="text-danger material-symbols-outlined">cancel</span>
                                                                    @endif
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="log-item-message">{{$log->message}}</span>
                                                                    <div>
                                                                        <span class="log-item-date">{{date('d/m/Y \á\s H:i' , strtotime($log->created_at))}}</span>
                                                                        @if(count($log->messages_sended)>0)
                                                                            <a data-bs-toggle="modal" data-bs-target="#listMessages_{{$log->id}}" class="log-item-messages">
                                                                                <span class="material-symbols-outlined">
                                                                                    forum
                                                                                </span>
                                                                            </a>
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                                <div class="modal fade" id="listMessages_{{$log->id}}" tabindex="-1" aria-labelledby="listMessages_{{$log->id}}" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                      <div class="modal-content">
                                                                        <div class="modal-body">
                                                                            <ul class="p-0 m-0" style="list-style: none">
                                                                                @foreach ($log->messages_sended as $key => $message)
                                                                                    <li class="log-item d-flex flex-row mb-3">
                                                                                        <div class="d-flex me-2">
                                                                                            <span class="text-info material-symbols-outlined">
                                                                                                chat_bubble
                                                                                            </span>
                                                                                        </div>
                                                                                        <div>
                                                                                            <div class="d-flex flex-column mb-2">
                                                                                                {{$message->client_name}}
                                                                                                <span class="log-item-date">{{$message->client_cellphone}}</span>
                                                                                            </div>
                                                                                            <span class="log-item-date">Mensagem:</span>
                                                                                            <div class="message-text me-1" >{{ $message->message }}</div>
                                                                                        </div>
                                                                                    </li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                      </div>
                                                                    </div>
                                                                </div>
                                                            </li>




                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <p>
                                                    Nenhum evento foi disparado ainda
                                                </p>
                                            @endif
                                        </div>
                                        <div class="tab-pane fade" id="pills-updated" role="tabpanel" aria-labelledby="pills-updated-tab">

                                            @if(isset($event->log_updates))
                                                <div class="col-sm-12 d-flex flex-row">
                                                    <ul style="list-style:none;overflow:auto;max-height:600px" class="w-100 p-0 m-0">
                                                        @foreach ($event->log_updates as $key => $log)
                                                            <li class="log-item d-flex flex-row">
                                                                <div class="d-flex align-items-center me-2">
                                                                    <span class="text-info material-symbols-outlined">info</span>
                                                                </div>
                                                                <div class="d-flex flex-column">
                                                                    <span class="log-item-message">{{$log->message}}</span>
                                                                    <span class="log-item-date">{{date('d/m/Y \á\s H:i' , strtotime($log->created_at))}}</span>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <p>
                                                    Nenhum evento foi disparado ainda
                                                </p>
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
</div>


@endsection
