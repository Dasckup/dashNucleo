<form name="submit-update-address" action="{{route('author.update.address', ['id' => $author->id])}}" method="POST">
    @method('PUT')
    @csrf
    <div class="row m-b-xxl">
        <div class="col-sm-4">
            <div class="form-check form-check-inline">
                <input {{trim($author->address->addressline)==""?"checked":""}} class="form-check-input" type="checkbox" name="address_from_brazil" id="address_from_brazil">
                <label class="form-check-label" for="address_from_brazil" style="font-size: 12px">O Autor está no Brasil</label>
            </div>
        </div>
    </div>

    <div class="row m-b-xxl">
        <div class="col-sm-4">
            <label class="form-label">CEP/Zipcode <code>*</code></label>
            <input name="zipcode" id="zipcode" type="text" value="{{$author->address->zipcode}}" class="form-control" placeholder="">
        </div>
    </div>

    <div id="internacional_mode" style="display: {{trim($author->address->addressline)==""?"none":"block"}}">
        @php
            $addressline1 = str_decryptData($author->address->addressline);
            $addressline2 = str_decryptData($author->address->addressline2);
        @endphp

        <div class="row m-b-xxl">
            <div class="col-sm-4">
                <label class="form-label">País <code>*</code></label>
                <select class="form-select"  name="international_country" id="internacional_country">
                    <option value="{{$author->address->country}}">{{$author->address->country}}</option>
                    @include('pages.author.componets.options._countries')
                </select>
            </div>
        </div>

        <div class="row m-b-xxl">
            <div class="col-sm-5">
                <label  class="form-label">Cidade <code>*</code></label>
                <input name="internacional_city" id="international_city" type="text" value="{{$author->address->city}}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-3">
                <label  class="form-label">Estado <code>*</code></label>
                <input name="internacional_state" id="international_state" type="text" value="{{$author->address->state}}" class="form-control" placeholder="">
            </div>
        </div>

        <div class="row m-b-xxl">
            <div class="col-sm-4">
                <label  class="form-label">Linha de Endereço 1 <code>*</code></label>
                <input name="addressline1" id="addressline1" type="text" value="{{$addressline1}}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-4">
                <label  class="form-label">Linha de Endereço 2</label>
                <input name="addressline2" id="addressline2" type="text" value="{{$addressline2}}" class="form-control" placeholder="">
            </div>
        </div>
    </div>

    <div id="nacional_mode" style="display: {{trim($author->address->addressline)!=""?"none":"block"}}">
        @php
            $number = str_decryptData($author->address->number);
            $address = str_decryptData($author->address->address);
        @endphp

        <div class="row m-b-xxl">
            <div class="col-sm-5">
                <label  class="form-label">Endereço <code>*</code></label>
                <input name="address" id="address" type="text" value="{{$address}}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-3">
                <label  class="form-label">Número <code>*</code></label>
                <input name="number" id="number" type="text" value="{{$number}}" class="form-control" placeholder="">
            </div>
        </div>

        <div class="row m-b-xxl">
            <div class="col-sm-4">
                <label  class="form-label">Bairro <code>*</code></label>
                <input name="neighborhood" id="neighborhood" type="text" value="{{$author->address->neighborhood}}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-4">
                <label  class="form-label">Complemento</label>
                <input name="complement" id="complement" type="text" value="{{$author->address->complement}}" class="form-control" placeholder="">
            </div>
        </div>


        <div class="row m-b-xxl">
            <div class="col-sm-6">
                <label  class="form-label">Cidade <code>*</code></label>
                <input name="city" id="city" type="text" value="{{$author->address->city}}" class="form-control" placeholder="">
            </div>
            <div class="col-sm-2">
                <label  class="form-label">Estado <code>*</code></label>
                <input name="state" id="state" type="text" value="{{$author->address->state}}" class="form-control" placeholder="">
            </div>
        </div>
    </div>


    <div class="row m-t-xxl">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary button-submit">Salvar Informações</button>
        </div>
    </div>
</form>
