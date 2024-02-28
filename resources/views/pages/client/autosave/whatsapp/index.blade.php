@extends('main._index')

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Enviar Mensagem</h1>
                            <span>Encontre detalhes importantes de contato e perfis de forma eficiente.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{route('client.whatsapp.api')}}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="settingsInputFirstName" class="form-label">Número do remetente<code>*</code></label>
                                            <input type="text" class="form-control" id="to" name="to" placeholder="+55119999999">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <label for="settingsInputEmail" class="form-label">Mensagem <code>*</code></label>
                                            <textarea rows="10" name="message" type="text" class="form-control" placeholder="Escreva aqui..."></textarea>
                                            <div id="settingsEmailHelp" class="form-text">A mensagem que será enviada para o cliente</div>
                                        </div>
                                    </div>
                                    <div class="row m-t-lg">
                                        <div class="col">
                                            <button type="submit" class="btn btn-primary m-t-sm">Enviar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
