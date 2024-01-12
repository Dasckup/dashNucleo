@php


    $reportOptions = App\Http\Extensions\OptionsReport::get();
@endphp

    <div class="modal fade" id="report-modal" tabindex="-1" aria-labelledby="report-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-body p-3">


                    <form name="send-form-report">
                        <input style="display: none" type="text" id="to" name="to" readonly>
                        <input style="display: none" type="text" id="editors" name="editors" readonly>

                        @foreach ($reportOptions as  $index => $reportOption)
                            <div class="col-sm-12 mb-2">
                                <label class="label_radios_options_report form-label d-flex align-items-center card flex-row p-2 label_report_{{$reportOption['id']}}">
                                    <div style="width:fit-content">
                                        <input class="me-3 form-check-input" type="radio" name="report" id="report_{{$reportOption['id']}}" value="{{$reportOption['id']}}" onchange="changeBorderColor('report_{{$reportOption['id']}}', this)">
                                    </div>
                                    <div>
                                        <span style="font-size: 11px;" class="text-danger">{{$reportOption['label']}}</span>
                                        <div class="description-label-report">{{$reportOption['description']}}</div>
                                    </div>
                                </label>
                            </div>
                        @endforeach

                        <div class="col-sm-12 mb-2">
                            <label class="label_radios_options_report form-label d-flex card flex-column p-2 label_report_outer">
                                <div class="d-flex align-items-center ">
                                    <div style="width:fit-content">
                                        <input onclick="if(this.checked){document.querySelector('#select-outer').style.display='block'}" class="me-3 form-check-input" type="radio" name="report" id="report_outer" value="outer" onchange="changeBorderColor('report_outer', this)">
                                    </div>
                                    <div>
                                        <span style="font-size: 11px;" class="text-danger">Outro</span>
                                        <div class="description-label-report">Se nenhuma das opções acima descrevem o seu caso</div>
                                    </div>
                                </div>

                                <div class="mt-3" style="display:none" id="select-outer">
                                    <textarea style=" font-size: 11px!important; " class="form-control" name="report_description" id="report_description" cols="30" rows="3" placeholder="Descreva o motivo da denúncia"></textarea>
                                </div>
                            </label>
                        </div>


                        <div class="col-sm-12 mb-3 mt-3">
                            <label class="form-label d-flex align-items-center">
                                <div style="width:fit-content">
                                    <input class="me-3 form-check-input" type="checkbox" name="term-of-responsibility-report" id="" value="1">
                                </div>
                                <div style="font-size: 12px">
                                    Ao ler e compreender, concordo com o
                                    <a class="text-primary decoration-underline font-bold" data-bs-target="#term-of-responsibility-report" data-bs-toggle="modal" data-bs-dismiss="modal">Termo de Responsabilidade nas Denúncias</a>.
                                </div>
                            </label>
                        </div>

                        <div class="col-sm-12" >
                            <button type="submit" style="font-size:12px;font-weight:600" class="btn btn-primary w-100">Reportar Comentario</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>




    <div class="modal fade" id="term-of-responsibility-report" tabindex="-1" aria-labelledby="term-of-responsibility-report" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Termo de Responsabilidade nas Denúncias</h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#report-modal"></button>
                </div>
                <div class="modal-body " style=" padding-top: 5px; ">
                    <div class="col-sm-12 mb-3">
                        <a style="font-size:12px;cursor:pointer;" class="text-primary cursor-pointer decoration-underline" data-bs-toggle="modal" data-bs-dismiss="modal"  data-bs-target="#report-modal">Voltar</a>
                    </div>
                    <p style="font-size: 12px">Ao submeter uma denúncia através deste formulário, você se compromete a fornecer informações verdadeiras e precisas a respeito do conteúdo em questão. Entendemos a importância de manter nossa plataforma segura e livre de conteúdos inapropriados, e contamos com a sua colaboração para identificar violações de nossas políticas de uso.</p>
                    <p style="font-size: 12px">Atenção: Denúncias falsas, enganosas ou feitas com o intuito de causar dano a terceiros são estritamente proibidas. A realização de denúncias infundadas ou o uso indevido deste sistema de denúncias pode resultar em consequências negativas, incluindo, mas não se limitando a, o bloqueio total do seu acesso ao nosso sistema e/ou ações legais, se aplicável. Este mecanismo é disponibilizado para a proteção da comunidade e deve ser usado com responsabilidade.</p>
                    <p style="font-size: 12px">Ao enviar uma denúncia, você afirma estar ciente destes termos e concorda em respeitá-los. Agradecemos a sua cooperação e empenho em manter a integridade e segurança de nossa plataforma.</p>
                </div>
            </div>
        </div>
    </div>



    <script>
        function changeBorderColor(radioId, radio) {
            document.querySelectorAll('.label_radios_options_report').forEach(function(card) {
                card.style.borderColor = '';
            });

            if(radio.value != 'outer') {
                document.querySelector('#select-outer').style.display='none'
            }

            if (radio.checked) {
                document.querySelectorAll('.label_'+radioId).forEach(function(card) {
                    card.style.borderColor = 'var(--bs-primary)';
                });
            }
        }
    </script>

