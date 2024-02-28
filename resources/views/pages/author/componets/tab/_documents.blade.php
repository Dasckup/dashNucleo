<?php
    $rg = str_decryptData($author->document->rg);
    $cpf = str_decryptData($author->document->cpf);
    $documentInternacional = str_decryptData($author->document->document);
    $nascimento = str_decryptData($author->document->birthday);
?>

    <div class="row mb-3">
        <div class="col-sm-4">
            <label class="card label-check-documentation-status">
                <div style=" padding: 12px; font-weight: 500; " class="card-body d-flex justify-content-between">
                    <div class="label-documentation-verificied">
                        Documentação Completa
                    </div>
                    <div>
                        <div class="form-check form-switch m-0">
                            <input {{$author->document->is_complete?"checked":""}} name="documentation_complete" class="form-check-input" type="checkbox">
                        </div>
                    </div>
                </div>
            </label>
        </div>
        <div class="col-sm-4">
            <label class="card label-check-documentation-status">
                <div style=" padding: 12px; font-weight: 500; " class="card-body d-flex justify-content-between">
                    <div class="label-documentation-verificied">
                        Documentação Verificada
                    </div>
                    <div>
                        <div class="form-check form-switch m-0">
                            <input id="isValid_checkboxInput" {{!$author->document->is_complete?"disabled":""}} {{$author->document->is_valid?"checked":""}} name="documentation_valid" class="form-check-input" type="checkbox">
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>


    <form name="submit-update-documentation" method="POST" action="{{route("author.update.documentation" , ["id" => $author->id])}}">
        @method('PUT')
        @csrf
        <div class="row m-b-xxl">
            <div class="col-sm-4">
                <label  class="form-label">Data de nascimento</label>
                <input name="birthday" type="text" value="{{date('d/m/Y', strtotime($nascimento))}}" class="form-control flatpickr-date-birthDay" aria-describedby="settingsCurrentPassword" placeholder="">
            </div>
        </div>

        <div class="row m-b-xxl">
            <div class="col-sm-4">
                <div class="form-check form-check-inline">
                    <input {{trim($author->address->documentInternacional)==""?"checked":""}} class="form-check-input" type="checkbox" name="doc_from_brazil" id="doc_from_brazil">
                    <label class="form-check-label" for="address_from_brazil" style="font-size: 12px">O Autor está no Brasil</label>
                </div>
            </div>
        </div>

        <div id="national_document" style="display:{{!$documentInternacional?"block":"none"}}">
            <div class="row m-b-xxl">
                <div class="col-sm-4">
                    <label for="rg" class="form-label">RG</label>
                    <div class="position-relative">
                        <input id="rg" name="rg" type="password" data-bs-toggle="hide" value="{{$rg}}" class="form-control " aria-describedby="settingsCurrentPassword" placeholder="">
                        <span id="turn-on-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                            visibility
                        </span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <label for="cpf" class="form-label">CPF</label>
                    <div class="position-relative">
                        <input id="cpf" name="cpf" type="password" data-bs-toggle="hide" value="{{$cpf}}" class="form-control " aria-describedby="settingsCurrentPassword" placeholder="">
                        <span id="turn-off-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                            visibility
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div id="international_document" style="display:{{$documentInternacional?"block":"none"}}">
            <div class="col-sm-4 m-b-xxl">
                <label for="international_doc" class="form-label">Documento de Identificação</label>
                <div class="position-relative">
                    <input id="international_doc" name="international_doc" type="password" data-bs-toggle="hide" value="{{$documentInternacional}}" class="form-control " aria-describedby="settingsCurrentPassword" placeholder="">
                    <span id="turn-off-visibility" class="me-3 turn-on-off-visibility position-absolute material-symbols-outlined">
                        visibility
                    </span>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary button-submit">Salvar informações</button>
        </div>
    </form>
