@section('js')
    <script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
    <script src="{{ asset('js/admin/form.js') }}"></script>
@stop


@include('core::admin._buttons-form')

<div class="row">

    {!! BootForm::hidden('id') !!}
    {!! BootForm::hidden('folder_id')->value($model->folder_id ?: 0) !!}
    {!! BootForm::hidden('gallery_id')->value($model->gallery_id ?: 0) !!}
    {!! BootForm::hidden('user_id')->value($model->user_id ?: 0) !!}
    {!! BootForm::hidden('type') !!}
    {!! BootForm::hidden('position')->value($model->position ?: 0) !!}
    {!! BootForm::hidden('path') !!}
    {!! BootForm::hidden('filename') !!}
    {!! BootForm::hidden('extension') !!}
    {!! BootForm::hidden('mimetype') !!}
    {!! BootForm::hidden('width') !!}
    {!! BootForm::hidden('height') !!}
    {!! BootForm::hidden('download_count')->value($model->download_count ?: 0) !!}

    <div class="col-sm-6">

        @include('core::admin._tabs-lang')

        <div class="tab-content">

            @foreach ($locales as $lang)

            <div class="tab-pane fade @if ($locale == $lang)in active @endif" id="{{ $lang }}">
                {!! BootForm::text(trans('validation.attributes.alt_attribute'), $lang.'[alt_attribute]') !!}
                {!! BootForm::textarea(trans('validation.attributes.description'), $lang.'[description]') !!}
                {!! BootForm::text(trans('validation.attributes.keywords'), $lang.'[keywords]') !!}
            </div>

            @endforeach

        </div>

    </div>

    <div class="col-sm-6">

        @include('core::admin._image-fieldset', ['field' => 'filename'])

        <table class="table table-condensed">
            <thead>
                <th>{{ trans('validation.attributes.file information') }}</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <th>{{ trans('validation.attributes.path') }}</th>
                    <td>{{ $model->path }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.filename') }}</th>
                    <td>{{ $model->filename }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.extension') }}</th>
                    <td>{{ $model->extension }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.mimetype') }}</th>
                    <td>{{ $model->mimetype }}</td>
                </tr>
                @if ($model->width)
                <tr>
                    <th>{{ trans('validation.attributes.width') }}</th>
                    <td>{{ $model->width }} px</td>
                </tr>
                @endif
                @if ($model->height)
                <tr>
                    <th>{{ trans('validation.attributes.height') }}</th>
                    <td>{{ $model->height }} px</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>

</div>
