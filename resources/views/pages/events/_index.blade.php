@extends('main._index')

@section('css')
    <style>
        .nav-link:not(.active){
            border-color: transparent !important;
        }
    </style>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        #onStoped_wrapper label{
            font-size: 12.7px;
            font-weight: 600;
            color: #717171;
        }
        .dataTables_filter#onStoped_filter label, .dataTables_length#onStoped_length label, .dataTables_info#onStoped_info {
            font-size: 12.7px;
            font-weight: 600;
            color: #717171;
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

        .toast {
            position: fixed;
            top: 10px;
            right: 10px;
            padding: 10px;
            background-color: #333;
            color: white;
            border-radius: 5px;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            }

            .toast.show {
            opacity: 1;
            }
    </style>


<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endsection

@section('js')
    <script src="{{custom_asset("/template/assets/js/datatables.js")}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#onStoped').DataTable({
                "language": {
                    "sZeroRecords": "Nenhum resultado encontrado",
                    "paginate": {
                        "next": ">",
                        "previous": "<"
                    },
                    "info": "Mostrando _START_ até _END_ de _TOTAL_",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0",
                    "infoFiltered": "(Filtrando de _MAX_)",
                    "decimal": ",",
                    "thousands": ".",
                    "lengthMenu": "Mostrando _MENU_",
                    "search": "Buscar:"
                },
                "order": [[0, "desc"]]
            });

            $('.select-date').select2();
            $('.select-group-events').select2();

            $('#infinit-mode').on('click', () => {
                const input = $('#infinit-mode input');

                if(input.is(':checked')){
                    $('#set-limit').addClass('d-none');
                }else{
                    $('#set-limit').removeClass('d-none');
                }
            })

            $('.select-group-events').on('change', (e) => {
                const value = JSON.parse(e.target.value)[0];
                if(value == 2){
                    $('#display_actions_checkbox').removeClass('d-none');
                }else{
                    $('#display_actions_checkbox').addClass('d-none');
                }
            })


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

            $("#on_time_to_send").on('click', (e) => {

                const input = $('#on_time_to_send input');
                if(input.is(':checked')){
                    $('#select_time_to_send').removeClass('d-none');
                }else{
                    $('#select_time_to_send').addClass('d-none');
                }
            })

            $('form[name="newEvent"]').on('submit', function(e){
                e.preventDefault();
                const camposParaValidar = ['message', 'to', 'send_on_date_amount', 'send_on_date'];
                const form = e.target;
                var invalid = false;

                camposParaValidar.forEach(campo => {
                    if(!form[campo].value){
                        form[campo].classList.add('is-invalid');
                        invalid = true;
                    }else{
                        form[campo].classList.remove('is-invalid');
                    }
                })

                if(!form['infinit_mode'].checked){
                    if(!form['limit_ciclo'].value || form['limit_ciclo'].value < 1 || form['limit_ciclo'].value > 100){
                        form['limit_ciclo'].classList.add('is-invalid');
                        invalid = true;
                    }else{
                        form['limit_ciclo'].classList.remove('is-invalid');
                    }
                }

                if(invalid){
                    return;
                }

                const formData = new FormData(form);
                formData.append('to', JSON.parse(form['to'].value)[0]);

                $.ajax({
                    url: "<?=route('events.store')?>",
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                        $('#addEvent').modal('hide');
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        $('#addEvent').modal('hide');
                        window.location.reload();
                    }
                });
            })


            $("#submitNewEvent").on('click', () => {
                const camposParaValidar = ['message', 'to', 'send_on_date_amount', 'send_on_date'];
                const form = $('form[name="newEvent"]');
                var invalid = false;

                camposParaValidar.forEach(campo => {
                    const campoElement = form.find(`[name="${campo}"]`); // Encontrar o campo pelo nome
                    if(!campoElement.val()){
                        campoElement.addClass('is-invalid');
                        invalid = true;
                    } else {
                        campoElement.removeClass('is-invalid');
                    }
                });

                if(!form.find('[name="infinit_mode"]').prop('checked')){
                    const limitCiclo = form.find('[name="limit_ciclo"]');
                    if(!limitCiclo.val() || limitCiclo.val() < 1 || limitCiclo.val() > 100){
                        limitCiclo.addClass('is-invalid');
                        invalid = true;
                    } else {
                        limitCiclo.removeClass('is-invalid');
                    }
                }

                if(invalid){
                    return;
                }

                const message = form.find('[name="message"]').val();
                const to = JSON.parse(form.find('[name="to"]').val())[1];

                const send_on_date_amount = form.find('[name="send_on_date_amount"]').val();
                const send_on_date = form.find('[name="send_on_date"]').val();
                const limit_ciclo = form.find('[name="limit_ciclo"]').val();
                const infinit_mode = form.find('[name="infinit_mode"]').prop('checked');

                const only_not_contacted = form.find('[name="only_not_contacted"]').prop('checked');
                const send_per_return_level = form.find('[name="send_per_return_level"]').prop('checked');

                const comercial_time = form.find('[name="comercial_time"]').prop('checked');
                const group_events = form.find('[name="group_events"]').val();

                var text_ciclo_type = "";
                if(infinit_mode){
                    text_ciclo_type = "<b>num ciclo infinito<b>";
                }else{
                    text_ciclo_type = `<b>num limite de ${limit_ciclo} ciclo(s)</b>`;
                }
                var send_on_date_amount_text = "";
                switch (send_on_date) {
                    case 'days':
                        send_on_date_amount_text = 'dias';
                        break;
                    case 'weeks':
                        send_on_date_amount_text = 'semanas';
                        break;
                    case 'months':
                        send_on_date_amount_text = 'meses';
                        break;
                    case 'yers':
                        send_on_date_amount_text = 'anos';
                        break;
                    default:
                        send_on_date_amount_text = 'dias';
                        break;
                }

                var horario_comercial = "";
                if(comercial_time){
                    const horario_comercial_de = form.find('[name="horario_comercial_de"]').val();
                    const horario_comercial_ate = form.find('[name="horario_comercial_ate"]').val();
                    horario_comercial = `no horario comercial de ${horario_comercial_de} até ${horario_comercial_ate}`;
                }

                const resume = `Enviar mensagem <b>"${message}"</b> para <b>${to}</b> a cada <b>${send_on_date_amount} ${send_on_date_amount_text}</b>, <b>${horario_comercial}</b>, ${text_ciclo_type}`;
                $("#text-message-resume").html(resume);

                $("#addEvent").modal('show');
            });


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
<div id="toast-container" class="toast-container"></div>
<div class="app-content">
    <div class="content-wrapper">
        <div class="">
            <div class="row">
                <div class="col">
                    <div class="page-description pt-2 ps-0 pb-0 page-description-tabbed">
                        <h1 class="d-flex align-items-center pt-0"> Mensagens automáticas </h1>
                        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                            <li class="nav-item " role="presentation">
                                <button  class="nav-link active text-success border-success d-flex align-items-center" id="andamento-tab" data-bs-toggle="tab" data-bs-target="#andamento" type="button" role="tab" aria-controls="security" aria-selected="false"><i style=" font-size: 14px; " class="material-icons me-1">cached</i> Em andamento </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-danger border-danger d-flex align-items-center" id="parados-tab" data-bs-toggle="tab" data-bs-target="#parados" type="button" role="tab" aria-controls="integrations" aria-selected="false"><i style=" font-size: 14px; " class="material-icons me-1">block</i> Parados </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link text-info  border-info d-flex align-items-center" id="novo-tab" data-bs-toggle="tab" data-bs-target="#novo" type="button" role="tab" aria-controls="hoaccountme" aria-selected="true"><i style=" font-size: 14px; " class="material-icons me-1">more_time</i> Novo evento</button>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="andamento" role="tabpanel" aria-labelledby="andamento-tab">
                            <div class="card">
                                <div class="card-body">
                                    @include('pages.events.onProgress.index', ['eventsInProgress' => $eventsInProgress])
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="parados" role="tabpanel" aria-labelledby="parados-tab">
                            <div class="card">
                                <div class="card-body">
                                    @include('pages.events.onBlocked.index', ['eventsInBlocked' => $eventsInBlocked])
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="novo" role="tabpanel" aria-labelledby="novo-tab">
                            <div class="card col-sm-5">
                                <div class="card-body">
                                    @include('pages.events.onNew.index')
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
