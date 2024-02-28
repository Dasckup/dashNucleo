<?php
    function groupByDate($array) {
        $result = [];
        foreach ($array as $item) {
            $date = date('Y-m-d', strtotime($item['created_at']));
            if(date('d/m/Y', strtotime($item['created_at']))==date('d/m/Y')){
                $date = 'Hoje';
            }

            $result[$date][] = $item;
        }
        return $result;
    }

    if($author->files){
        $groupedData = groupByDate($author->files);
    }else{
        $groupedData = [];
    }
?>

<a data-bs-toggle="modal" data-bs-target="#new-material-upload" class="btn btn-primary button-add-file">
    Adicionar arquivo
</a>

<div class="modal fade" id="new-material-upload" aria-hidden="true" aria-labelledby="..." tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="blockui-form-upload-material">

                <h5 class="title-form-upload-file d-flex justify-content-between">
                    <span>Enviar arquivo</span>
                    <button style="font-size: 9px;" type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </h5>


                <form name="form-upload-new-material">
                    <div class="mb-3">
                        <label class="form-label">Nome do arquivo <code>*</code></label>
                        <input name="name" onblur="checkSpecialCharInput(this)" type="text" class="form-control">
                        <div class="invalid-feedback">
                            O nome do arquivo não pode conter [$, *, ¨, #, /, }, {, @, |, \, .]
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label w-100">
                            Clique aqui ou arraste e solte o arquivo <code>*</code>
                        </label>
                        <div>
                            <div id="fileDrop" ondrop="handleDrop(event)" ondragover="allowDrop(event)" ondragenter="addDragoverClass()" ondragleave="removeDragoverClass()" onclick="clickFileInput()">
                                <span class="material-symbols-outlined" style="font-size: 35px;color: #666;">
                                    upload_file
                                </span>
                                <input type="file" id="fileInput" name="fileInput" onchange="validateAndShowFileInfo(event)" accept=".docx, .pdf, .doc, .jpge, .jpg, .png"  style="display: none;">
                            </div>
                            <div class="invalid-feedback">
                                O documento deve ser no formato ( docx, doc, pdf, jpge, jpg, png )
                            </div>
                        </div>
                        <div id="fileInfo">
                        </div>
                    </div>

                    <button class="btn btn-primary w-100" style="font-size: 12px">
                        Enviar arquivo
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-7">
        @if($author->files)
            <div class="events_list">

                @if(count($groupedData)>0)

                    @foreach ($groupedData as $key => $fileList)
                    <div class="events">

                        <div class="events-line position-relative">
                            <span class="event-line-icon-top material-symbols-outlined">
                                trip_origin
                            </span>
                            <div class="events-line-background"></div>
                            <span class="event-line-icon-bottom material-symbols-outlined">
                                trip_origin
                            </span>
                        </div>


                        <div class="d-flex flex-column" style="padding-left: 20px;">
                            <div class="events-date mb-3"><?php echo $key === "Hoje" ? $key : \Carbon\Carbon::parse($key)->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY') ?></div>

                            <div class="d-flex flex-column p-0 m-0" @if($key==="Hoje")id="today"@endif>
                                @foreach ($fileList as $file)
                                <div class="card file-card file-manager-recent-item">
                                    <div class="p-3">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                @php
                                                    $icon = "description";
                                                    if(in_array($file['extension'], ['jpg', 'jpeg', 'png'])){
                                                        $icon = "image";
                                                    }
                                                @endphp
                                                <i class="material-icons-outlined text-primary align-middle m-r-sm">{{$icon}}</i>
                                            </div>
                                            <div class="d-flex flex-column">
                                                <span class="file-item-title flex-fill">
                                                    @if($file)
                                                        {{$file['label']}}
                                                    @endif
                                                </span>
                                                <span style="font-size: 11px;">
                                                    @if($file)
                                                        <span >
                                                            @if($file['users'])
                                                                Enviado por: {{$file['users']['name']}}
                                                            @else
                                                                Enviado pelo autor <b class="text-transform-capitalize">{{$author->name}}</b>
                                                            @endif
                                                        </span>
                                                    @endif
                                                </span>
                                            </div>
                                            <a target="_blank" href="{{\App\Http\Middleware\AwsS3::getFile($file['url_material'])}}" class="file-manager-recent-file-actions" >
                                                <span class="material-symbols-outlined">
                                                    download
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    @endforeach

                @endif

            </div>
        @endif
    </div>


</div>
