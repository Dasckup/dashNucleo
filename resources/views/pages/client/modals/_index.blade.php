            <div class="modal fade" id="ModalSelecionarPrazo" tabindex="-1" aria-labelledby="ModalSelecionarPrazo" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h5>Selecione o Prazo</h5>
                            <p>O autor <b id="author-name-prazo"></b> ainda não contem um prazo, selecione um prazo para continuar</p>
                            <form name="formNewPrazo">
                                <input type="hidden" id="client" name="client" value="" />
                                <input type="hidden" id="status" name="status" value="" />
                                <div class="row">
                                    <div class="mb-3 col-sm-8">
                                        <label for="prazo" class="form-label">Prazo <code>*</code></label>
                                        <select class="form-select" id="prazo" name="prazo">
                                            {!! App\Models\Products::get()->map(function($item){
                                                return "<option value='{$item->id}'>{$item->title}</option>";
                                            })->implode("") !!}
                                        </select>
                                    </div>
                                    <div class="mb-3 col-sm-4">
                                        <label for="currency" class="form-label">Moeda <code>*</code></label>
                                        <select class="form-select" id="currency" name="currency">
                                            <option value="BRL">Real</option>
                                            <option value="USD">Dolar</option>
                                        </select>
                                    </div>
                                </div>
                                <button style="font-size: 12px;" type="submit" class="btn btn-primary p-2 fw-600 w-100 mt-4">Continuar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="ModalUpdateToCanceled" tabindex="-1" aria-labelledby="ModalUpdateToCanceled" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="d-flex justify-content-between w-100">
                                <h5 style="font-weight: 600;" class="mb-4" >
                                Cancelar Submissão
                                </h5>
                                <button style=" width: .3em; height: .3em; " type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form name="formUpdateToCanceled">
                                <input type="hidden" id="client" name="client" value="487">
                                <input type="hidden" id="status" name="status" value="">
                                <div class="row">
                                    <div class="mb-3 col-sm-12">
                                        <label for="prazo" class="form-label">Motivos <code>*</code></label>
                                        <select style="font-size: 12px;" class="form-select" id="reason" name="reason">
                                            <option value="Selecione">Selecione</option>
                                            {!! App\Models\StatusReasonsCancellation::get()->map(function($item){
                                                return "<option value='{$item->id}'>{$item->label}</option>";
                                            })->implode("") !!}
                                        </select>
                                    </div>

                                    <div class="mb-3 col-sm-12">
                                        <label for="prazo" class="form-label">Descreva o motivo <code>*</code></label>
                                        <textarea class="form-control" name="observation" id="" rows="5"></textarea>
                                        <div style="font-size: 11px" class="form-text">
                                            Descreva os motivos que levaram ao cancelamento da submissão
                                        </div>
                                    </div>


                                    <div class="form-check form-check-inline mb-2 mt-4 col-sm-12">
                                        <input class="form-check-input" type="checkbox" name="confirmation">
                                        <label class="form-check-label form-label" for="confirmation" style="
                                            font-size: 11px!important;
                                            font-weight: 500!important;
                                        ">
                                        Eu {{Auth::user()->name}}, afirmo está ciente e confirmo o cancelamento da submissão [#<b id="id-submission">487</b>] pertecente autor(a) <b id="author-name-checkbox">Flavio Del Nero</b>
                                        </label>
                                    </div>

                                </div>
                                <button style="font-size: 12px;font-weight: 600;" type="submit" class="btn btn-primary p-2 fw-600 w-100">Continuar com o cancelamento</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
