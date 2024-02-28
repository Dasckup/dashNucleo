<?php
$nascimento = str_decryptData($author->document->birthday);
?>

<form name="submit-update-information" action="{{route('author.update.information', ['id' => $author->id])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="row m-b-xxl">
        <div class="col-sm-4">
            <label class="form-label">Nome <code>*</code></label>
            <input name="name" type="text" value="{{$author->name}}" class="form-control bg-transparent" placeholder="">
        </div>
        <div class="col-sm-4">
            <label class="form-label">Sobrenome <code>*</code></label>
            <input name="last_name" type="text" value="{{$author->last_name}}" class="form-control bg-transparent" placeholder="">
        </div>
    </div>

    <div class="row m-b-xxl">
        <div class="col-sm-4">
            <label  class="form-label">E-mail <code>*</code></label>
            <input name="email" type="text" value="{{$author->email}}" class="form-control bg-transparent" placeholder="">
        </div>
        <div class="col-sm-1">
            <label  class="form-label">DDI <code>*</code></label>
            <input name="ddi" type="text" value="{{$author->ddi}}" class="form-control bg-transparent" placeholder="">
        </div>
        <div class="col-sm-3">
            <label  class="form-label">Celular <code>*</code></label>
            <input name="cellphone" type="text" value="{{$author->cellphone}}" class="form-control bg-transparent" placeholder="">
        </div>
    </div>

    <div class="row m-b-xxl">
        <div class="col-sm-2">
            <label class="form-label">Idade</label>
            <input readonly type="text" value="{{ageCalculator($nascimento)}} anos" class="form-control bg-transparent" placeholder="">
        </div>
        <div class="col-sm-2">
            <label class="form-label">Próximo Aniversário 🎉</label>
            <input readonly type="text" value="{{nextHappyBirthDay($nascimento)}}" class="form-control bg-transparent" placeholder="">
        </div>
    </div>

    <div class="row m-t-xxl">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary button-submit">Salvar Informações</button>
        </div>
    </div>
</form>
