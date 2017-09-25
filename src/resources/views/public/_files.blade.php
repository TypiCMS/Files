@if ($model->files->count())
    <ul class="files-list">
    @foreach ($model->files as $file)
        <li class="files-list-item">
            @if ($file->type == 'i')
            <a class="files-list-image" href="{!! $file->present()->thumbSrc(1200, 1200, array('resize'), 'name') !!}" data-caption="{{ $file->alt_attribute }}" data-fancybox="{{ $model->slug ? : 'group' }}">
                <img class="files-list-image-thumb" src="{!! $file->present()->thumbSrc(370, 370, array(), 'name') !!}" alt="{{ $file->alt_attribute }}">
            </a>
            @else
            <a class="files-list-document" href="{{ asset('storage/'.$file->path) }}" target="_blank">
                <span class="files-list-document-icon fa fa-file-o fa-3x"></span>
                <span class="files-list-document-filename">{{ $file->name }}</span> <small class="files-list-document-filesize">({{ $file->present()->filesize }})</small>
            </a>
            @endif
        </li>
    @endforeach
    </ul>
@endif
