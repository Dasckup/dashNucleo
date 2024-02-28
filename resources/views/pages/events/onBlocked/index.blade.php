<table id="onStoped" class="display table align-middle  table-bordered border-primary" style="width:100%">
    <thead>
    <tr>
        <th style="width:5%" class="text-center">Status</th>
        <th style="width:30%">Para</th>
        <th style="width:35%">Mensagem</th>
        <th style="width:15%">A cada</th>
        <th style="width:15%" class="text-center">Retomar</th>
    </tr>
    </thead>
    <tbody>
        @foreach($eventsInBlocked as $response)
            <tr>
                <td style="width:5%">
                    <div style="width: fit-content">
                        <div class="spinner-grow text-danger" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </td>
                <td style="width:30%">
                    {{ $response->groups->label }}
                </td>
                <td style="width:40%">
                    <div style="min-width:300px" class="d-flex">
                        <div  class="message-text me-1">{{ $response->message }}</div>
                        <a href="<?=route('events.show', ['event' => $response->id])?>">
                            <i style="font-size: 17px;color: #0067ef;"
                               class="material-icons">
                               edit_square
                            </i>
                        </a>
                    </div>
                </td>
                <td  style="width:15%" class="text-center">
                    <div>{{$response->on_date_amount}} {{ GetTransletedDay($response->on_date) }}</div>
                </td>
                <td style="width:10%">
                    <div class="text-center">
                        <a style=" padding: 4px 2px 3px 11px; " href="{{route('events.start', ['event' => $response->id])}}" class="btn btn-success btn-sm" onclick="return confirm('Tem certeza que deseja retomar este evento?')">
                            <i class="material-icons">play_arrow</i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
