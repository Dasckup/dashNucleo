@extends('main._index')

@section('css')
@endsection

@section('js')
    <script src="{{asset("/template/assets/js/datatables.js")}}"></script>
@endsection

@section('content')
    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Log do Sistema</h1>
                            <span>Encontre detalhes importantes sobre o funcionamento do sitema, transações, atualizações e muito mais.</span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="width:0%;" class="text-center d-none">#</th>
                                        <th style="width:20%" class="text-center">Colaborador</th>
                                        <th style="width:55%">Mensagem</th>
                                        <th style="width:10%" class="text-center">Endereço de IP</th>
                                        <th style="width:20%">Data</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($logs as $log)
                                            <tr>
                                                <td class="d-none text-center">
                                                    {{$log->id}}
                                                </td>
                                                <td class="text-center">
                                                    #{{$log->user}} {{$log->users->name}}
                                                </td>
                                                <td >
                                                    {{$log->message}}
                                                </td>
                                                <td class="text-center">
                                                    {{$log->ip}}
                                                </td>
                                                <td class="text-center">
                                                    {{date("d/m/Y H:i:s" , strtotime($log->created_at))}}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
