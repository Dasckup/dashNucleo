<form name="new-note-message" class="col-sm-6">
    <label class="form-label">Mensagem</label>
    <textarea name="note-message" id="note-message" rows="4" class="form-control mb-3" placeholder="Escreva aqui..."></textarea>
    <div class="col-sm-12 mb-3">
        <div style=" padding-left: 1.5rem; " class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" id="is_task" name="is_task">
            <label class="form-check-label" for="is_task" style="font-size: 12px">Tornar uma tarefa</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary button-add-note">
        Adicionar nota
    </button>
</form>

@if($author->notes)
    <div id="list-notes" class="d-flex flex-column col-sm-12">
        @foreach ($author->notes as $note)
            <div style=" border-radius: 6px;border: 1px solid #e7e7e7; padding: 15px;" class="col-sm-6 mb-2">
                <div class="d-flex">
                    <div class="me-3">
                        <img style=" width: 34px; border-radius: 100%; " src="{{photo_user($note->users->cover)}}" alt="">
                    </div>
                    <div class="d-flex flex-column">
                        <span class="file-item-title flex-fill">
                            {{$note->users->name}}
                        </span>
                        <span style="font-size: 11px;">
                            {{$note->message}}
                        </span>
                    </div>
                </div>
                <div class="mt-2 w-100 d-flex justify-content-end" style="font-size: 11px;color:#666">
                    {{date('d/m/Y \á\s H:i', strtotime($note->created_at))}}
                </div>
            </div>
        @endforeach
    </div>
@endif
