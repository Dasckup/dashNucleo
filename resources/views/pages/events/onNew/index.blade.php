<form name="newEvent">
    @csrf
    <div class="col-sm-8">
        <div class="row">
            <div class="col-md-12">
                <label for="settingsInputFirstName" class="form-label">Para: <code>*</code></label>
                <select class="select-group-events w-100" name="to">
                    @foreach (App\Http\Middleware\EventsGroups::get() as $group)
                        <option label="" value='[{{$group->id}},"{{$group->label}}"]'>{{$group->label}}</option>
                    @endforeach
                  </select>
                <div id="settingsEmailHelp" class="form-text">Selecione um grupo para quem será enviado</div>
            </div>
        </div>

        <div class="d-none" id="display_actions_checkbox">
            <div class="row mt-4">
                <label id="option-check-returned" class="form-label d-flex aling-items-center" style=" line-height: 21px; ">
                    <input name="only_contact_returned" type="checkbox" class="form-check-input me-2"> Somente intenções que não retornaram contato
                </label>
                <label id="option-check-returned-level" class="form-label d-none ms-4 " style=" line-height: 21px; ">
                    <input name="send_per_return_level" type="checkbox" class="form-check-input me-2"> Enviar por nivel de retorno
                </label>
                <label class="form-label d-flex aling-items-center mt-2" style=" line-height: 21px; ">
                    <input name="only_not_contacted" type="checkbox" class="form-check-input me-2"> Somente intenções que não foram receberam contato
                </label>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-sm-12 mb-1">
                <label for="settingsInputFirstName" class="form-label">Enviar a cada: <code>*</code></label>
            </div>
            <div class="col-md-6">
                <input name="send_on_date_amount" placeholder="Exemplo: 3" type="number" min="1" max="100" class="form-control">
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
                <label id="option-check-returned-level" class="form-label" style=" line-height: 21px; ">
                    <input name="only_bussines_days" type="checkbox" class="form-check-input me-2"> Apenas dias úteis
                </label>
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

        <div class="row mt-4">
            <div class="col-md-12">
                <label for="settingsInputFirstName" class="form-label">Mensagem: <code>*</code></label>
                <textarea  class="form-control" name="message" id="" cols="30" rows="10"></textarea>
                <div id="settingsEmailHelp" class="form-text">Shortcode: {name} = Nome do cliente</div>
            </div>
        </div>

        <div class="col-sm-12 mt-3">
            <button type="button" id="submitNewEvent" class="btn btn-primary m-t-sm">Adicionar evento</button>
        </div>
    </div>

    <div class="modal fade" id="addEvent" tabindex="-1" aria-labelledby="addEvent" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-body">
                <div>
                    <div class="d-flex flex-row justify-content-between align-items-center mb-3">
                        <div style="font-weight:bold">Você tem certeza?</div>
                        <button style="box-shadow:none; width: 0.3em; padding: 4px; height: 0.3em; " type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <p>Seu evento será adicionado e não poderá ser editado</p>
                    <br />

                    <p style="font-weight:bold">Resumo do evento:</p>
                    <p id="text-message-resume">
                    </p>

                    <button type="submit" class="btn btn-primary w-100 mt-3">
                        Estou ciente, pode continuar
                    </button>
                </div>

            </div>
          </div>
        </div>
      </div>

</form>

<script>

</script>
