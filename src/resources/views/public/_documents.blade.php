@if ($documents->count() > 0)
<ul class="documents-list">
    @foreach ($documents as $document)
    <li class="documents-item">
        <a class="documents-item-link" href="{{ asset('storage/'.$document->path) }}" target="_blank" download>
            <span class="documents-item-icon fa fa-file-o fa-2x"></span>
            <div class="documents-item-info">
                <span class="documents-item-name">{{ $document->name }}</span>
                <small class="documents-item-size">({{ $document->present()->filesize }})</small>
            </div>
        </a>
    </li>
    @endforeach
</ul>
@endif
