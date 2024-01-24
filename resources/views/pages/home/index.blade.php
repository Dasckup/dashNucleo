@extends('main._index')

@section('css')
@endsection

@section('js')

@endsection

@section('content')


@php
$monthTranslations = [
    'January' => 'Janeiro',
    'February' => 'Fevereiro',
    'March' => 'Março',
    'April' => 'Abril',
    'May' => 'Maio',
    'June' => 'Junho',
    'July' => 'Julho',
    'August' => 'Agosto',
    'September' => 'Setembro',
    'October' => 'Outubro',
    'November' => 'Novembro',
    'December' => 'Dezembro'
]
@endphp

    <div class="app-content">
        <div class="content-wrapper">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="page-description">
                            <h1>Dashboard</h1>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-warning">
                                        <i class="material-icons-outlined">pending_actions</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Avaliações Pendente</span>
                                        <span class="widget-stats-amount">{{$pending_review_count['total']}}</span>
                                        <span class="widget-stats-info">{{$pending_review_count['currentMonth']}} no mês de {{$monthTranslations[now()->translatedFormat('F')]??null}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-primary">
                                        <i class="material-icons-outlined">inventory</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Submissões Aceitas</span>
                                        <span class="widget-stats-amount">{{$submissions_accept['total']}}</span>
                                        <span class="widget-stats-info">{{$submissions_accept['currentMonth']}} no mês de {{$monthTranslations[now()->translatedFormat('F')]??null}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card widget widget-stats">
                            <div class="card-body">
                                <div class="widget-stats-container d-flex">
                                    <div class="widget-stats-icon widget-stats-icon-danger">
                                        <i class="material-icons-outlined">content_paste_off</i>
                                    </div>
                                    <div class="widget-stats-content flex-fill">
                                        <span class="widget-stats-title">Submissões Recusadas</span>
                                        <span class="widget-stats-amount">{{$submission_refused['total']}}</span>
                                        <span class="widget-stats-info">{{$submission_refused['currentMonth']}} no mês de {{$monthTranslations[now()->translatedFormat('F')]??null}}</span>
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

