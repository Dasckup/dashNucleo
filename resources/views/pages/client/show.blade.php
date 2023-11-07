@extends('main._index')

@section('css')

@endsection

@section('js')

@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description page-description-tabbed ">
                            <div class="d-flex align-items-center">
                                <div class="page-description-content flex-grow-1">
                                    <h1 class="d-flex align-items-center">

                                        @if(!empty($client->address->country))
                                        <div><i title="internacional" class="material-icons text-primary" style=" font-size: 32px; margin-right: 9px; margin-top: 12px; ">public</i></div>
                                        @endif

                                        <div>
                                            {{$client->name}} {{$client->last_name}} <span style="font-size: 16px">#{{$client->id}}</span>
                                        </div>
                                    </h1>
                                </div>
                            </div>
                            <div class="w-100 mt-2">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="basic_information_tab" data-bs-toggle="tab" data-bs-target="#basic_information" type="button" role="tab" aria-controls="basic_information" aria-selected="true">Informações de Contato</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="address_tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="false">Endereço</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="submission_tab" data-bs-toggle="tab" data-bs-target="#submission" type="button" role="tab" aria-controls="submission" aria-selected="false">Submissão</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="material_tab" data-bs-toggle="tab" data-bs-target="#material" type="button" role="tab" aria-controls="material" aria-selected="false">Material</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>



                    <div class="card">
                        <div class="card-body">
                            <div class="tab-content" id="myTabContent">

                                <div class="tab-pane fade show active" id="basic_information" role="tabpanel" aria-labelledby="basic_information">
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">Nome</label>
                                            <input readonly type="text" value="{{$client->name}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">Sobrenome</label>
                                            <input readonly type="text" value="{{$client->last_name}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label  class="form-label">E-mail</label>
                                            <input readonly type="text" value="{{$client->email}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label  class="form-label">Celular</label>
                                            <input readonly type="text" value="{{$client->ddi}} {{$client->cellphone}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="address" role="tabpanel" aria-labelledby="address">

                                    <?php
                                        $number = \App\Http\Middleware\Cryptography::decrypt($client->address->number);
                                        $address = \App\Http\Middleware\Cryptography::decrypt($client->address->address);
                                    ?>

                                    @if(!empty($client->address->zipcode))
                                        <a target="_blank" class="d-flex align-items-center m-b-xxl" style="text-decoration: none;font-size: 12.5px;font-weight: 500;"
                                        href="https://www.google.com.br/maps/place/{{$address}},+{{$number}},+{{$client->address->city}}+-+{{$client->address->state}},+{{$client->address->zipcode}}/">
                                            <i class="material-icons me-2">share_location</i>    Acessar endereço via google maps
                                        </a>
                                   @endif


                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label class="form-label">País</label>
                                            <input readonly type="text" value="{{$client->address->country}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label class="form-label">CEP/Zipcode</label>
                                            <input readonly type="text" value="{{$client->address->zipcode}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>


                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Endereço</label>
                                            <input readonly type="text" value="{{$address}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label  class="form-label">Número</label>
                                            <input readonly type="text" value="{{$number}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-4">
                                            <label  class="form-label">Bairro</label>
                                            <input readonly type="text" value="{{$client->address->neighborhood}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-4">
                                            <label  class="form-label">Complemento</label>
                                            <input readonly type="text" value="{{$client->address->complement}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>


                                    <div class="row m-b-xxl">
                                        <div class="col-sm-6">
                                            <label  class="form-label">Cidade</label>
                                            <input readonly type="text" value="{{$client->address->city}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-2">
                                            <label  class="form-label">Estado</label>
                                            <input readonly type="text" value="{{$client->address->state}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>



                                </div>
                                <div class="tab-pane fade" id="submission" role="tabpanel" aria-labelledby="submission">
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Prazo escolhido por {{$client->name}}:</label>
                                            <input readonly type="text" value="{{$client->submission->term_publication_title}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <label  class="form-label">Valor do prazo:</label>
                                            <input readonly type="text" value="{{$client->submission->term_publication_price}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Onde {{$client->name}} encontrou a revista:</label>
                                            @if($client->submission->find_us!=="outro")
                                            <input readonly type="text" value="{{$client->submission->find_us}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            @else
                                            <input readonly type="text" value="{{$client->submission->outer_find_us}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Area de {{$client->name}}:</label>
                                            <input readonly type="text" value="{{$client->submission->area}}" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword" placeholder="">
                                        </div>
                                    </div>

                                    <div class="row m-b-xxl">
                                        <div class="col-sm-5">
                                            <label  class="form-label">Observações feitas por {{$client->name}}:</label>
                                            <textarea rows="7" readonly type="text" class="form-control bg-transparent" aria-describedby="settingsCurrentPassword">{{$client->submission->observation}}</textarea>
                                        </div>
                                    </div>





                                </div>
                                <div class="tab-pane fade" id="material" role="tabpanel" aria-labelledby="material">
                                    <div class="col-sm-7">
                                        <label  class="form-label">Material enviado por {{$client->name}}:</label>

                                        <div class="card file-manager-recent-item">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center">
                                                    <i class="material-icons-outlined text-primary align-middle m-r-sm">description</i>
                                                    <a href="#" class="file-manager-recent-item-title flex-fill">{{$client->material->name_material}}</a>
                                                    <span class="p-h-sm">{{$client->material->size_material}}</span>
                                                    <span class="p-h-sm text-muted">{{date("d-m-Y", strtotime($client->material->created_at))}}</span>
                                                    <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($client->material->url_material)}}" class="file-manager-recent-file-actions" ><i class="material-icons">download</i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if($client->material->url_photo)
                                        <div class="col-sm-7">
                                            <label  class="form-label">Foto enviada por {{$client->name}}:</label>
                                            <div class="card file-manager-recent-item">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-icons-outlined text-primary align-middle m-r-sm">image</i>
                                                        <a href="#" class="file-manager-recent-item-title flex-fill">{{$client->material->name_photo}}</a>
                                                        <span class="p-h-sm">{{$client->material->size_photo}}</span>
                                                        <span class="p-h-sm text-muted">{{date("d-m-Y", strtotime($client->material->created_at))}}</span>
                                                        <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($client->material->url_photo)}}" class="file-manager-recent-file-actions" ><i class="material-icons">download</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

