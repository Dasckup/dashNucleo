<table id="onStoped" class="display table align-middle  table-bordered border-primary" style="width:100%">
    <thead>
    <tr>
        <th style="width:0%;" class="text-center d-none">#</th>
        <th style="width:4%" class="text-center">Status</th>
        <th style="width:35%">Para</th>
        <th style="width:30%">Mensagem</th>
        <th style="width:15%">A cada</th>
        <th style="width:15%" class="text-center">Retomar</th>
    </tr>
    </thead>
    <tbody>
        @foreach($eventsInBlocked as $response)
            <tr>
                <td class="d-none">{{ $response->id }}</td>
                <td style=" padding: 0px 26px!important; " class="text-center">
                    <div style=" margin: 0px -10px; " class="d-flex align-items-center justify-content-center">
                        <i class="material-icons" style="font-size: 35px;color: var(--bs-danger);">pause_circle</i>
                    </div>
                </td>
                <td >
                    {{ $response->groups->label }}
                </td>
                <td>
                    <div class="message-text">{{ $response->message }}</div>
                </td>
                <td class="text-center">
                    <div>{{$response->on_date_amount}} {{ GetTransletedDay($response->on_date) }}</div>
                </td>
                <td>
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
