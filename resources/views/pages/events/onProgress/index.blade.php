<style>
    .message-text:not(.message-show-all) {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        max-width: 400px;
    }
    .spinner-border {
        border-color: #0067ef!important;
        border-right-color: transparent!important;
    }
</style>
<script>
    function mostrarTexto() {
        var messageText = document.querySelector('.message-text');
        messageText.style.whiteSpace = 'normal';
        messageText.style.overflow = 'visible';
        messageText.style.textOverflow = 'clip';
    }
</script>
<table id="datatable1" class="display table align-middle  table-bordered border-primary" style="width:100%">
    <thead>
        <tr>
            <th style="width:0%;" class="text-center d-none">#</th>
            <th style="width:4%" class="text-center">Status</th>
            <th style="width:25%">Para</th>
            <th style="width:25%">Mensagem</th>
            <th style="width:15%">A cada</th>
            <th style="width:10%" >Limite</th>
            <th style="width:20%">Proximo</th>
            <th style="width:15%" class="text-center">Parar</th>
        </tr>
    </thead>
    <tbody>
        @foreach($eventsInProgress as $response)
            <tr>
                <td class="d-none">{{ $response->id }}</td>
                <td>
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </td>
                <td >
                    {{ $response->groups->label }}
                </td>
                <td>
                    <div class="d-flex">
                        <div class="message-text me-1">{{ $response->message }}</div>
                        <a href="<?=route('events.show', ['event' => $response->id])?>">
                            <i style="font-size: 17px;color: #0067ef;"
                               class="material-icons">
                               edit_square
                            </i>
                        </a>
                    </div>
                </td>
                <td class="text-center">
                    <div>{{$response->on_date_amount}} {{ GetTransletedDay($response->on_date) }}</div>
                </td>
                <td>
                    <div class="text-center">
                        @if($response->limit)
                            <span class="badge badge-success">{{ $response->limit }}</span>
                        @else
                            <span class="badge badge-success">Sem limite</span>
                        @endif
                    </div>
                </td>
                <td>
                    {{ date('d/m/Y \á\s H:i', strtotime($response->on))}}
                </td>
                <td>
                    <div class="text-center">
                        <a style=" padding: 4px 2px 3px 11px; " href="{{route('events.stop' , ['event' => $response->id])}}" class="btn btn-danger btn-sm" onclick="return confirm('Tem certeza que deseja parar o evento?')">
                            <i class="material-icons">pause</i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>


<?php

function GetTransletedDay($date) {
    switch ($date){
        case 'days':
        return 'dia(s)';
        break;
        case 'weeks':
        return 'semana(s)';
        break;
        case 'months':
        return 'mese(s)';
        break;
        case 'years':
        return 'ano(s)';
        break;
        case 'hours':
        return 'hora(s)';
        break;
        default:
        return 'dia(s)';
        break;
    }
}
