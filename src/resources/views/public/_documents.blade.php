@if ($model->documents->count() > 0)
    <ul class="document-list-list">
    @foreach ($model->documents as $document)
        <li class="document-list-item">
            <a class="document-list-item-link" href="{{ asset('storage/'.$document->path) }}" download>
                <span class="document-list-item-icon fa fa-file-o fa-2x"></span>
                <span class="document-list-item-filename">{{ $document->name }}</span> <small class="files-list-document-filesize">{{ $document->present()->filesize }}</small>
            </a>
        </li>
    @endforeach
    </ul>
@endif
