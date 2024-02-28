

<div class="material card card-body m-0 mb-2 p-3">
    <div class="d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column">
                <div class="material-title-process">
                #{{$process->proccess_id}}
                    <a onclick="copyText('{{$process->proccess_id}}')" class="text-primary">
                        <span style=" font-size: 15px;cursor: pointer; " class="material-symbols-outlined">
                            content_copy
                        </span>
                    </a>
                </div>
                <span class="material-deadline-process">Prazo: {{date('d/m/Y', strtotime($process->client->created_at. ' + '.$process->client->deadline_amount.' '.$process->client->deadline_type))}}</span>
            </div>
            <a href="{{route('AppModerator.material.show', ['id' => $process->proccess_id])}}" class="text-primary ms-2">
                <span style=" font-size: 25px;cursor: pointer; " class="material-symbols-outlined">
                    bubble
                </span>
            </a>
        </div>


        <div>
            <div class="d-flex flex-row justify-content-between mb-0 card p-2 align-items-center material-card" >
                <div class="d-flex flex-row align-items-center fw-600 me-2">
                    <div>
                        <img width="25px" height="25px" src="{{asset('/template/assets/images/icons/'.$process->client->material_content->file_last_version['extension'].'-icon.png')}}">
                    </div>
                    <div class="ms-2 d-flex flex-column">
                        <div class="text-black event-comment-material-name">{{$process->client->material_content->file_last_version['label']}}</div>
                        <div class="event-comment-material-size">{{$process->client->material_content->file_last_version['size_material']}}</div>
                    </div>
                </div>
                <div>
                    <a href="{{\App\Http\Middleware\AwsS3::getFile($process->client->material_content->file_last_version['url_material'])}}">
                        <span style="font-size:20px" class="material-symbols-outlined">download</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
