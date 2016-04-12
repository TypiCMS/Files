@include('core::admin._buttons-form')

<div class="row">

    {!! BootForm::hidden('id') !!}
    @if($model->gallery_id)
    {!! BootForm::hidden('gallery_id') !!}
    @endif
    {!! BootForm::hidden('type') !!}
    {!! BootForm::hidden('position')->value($model->position ?: 0) !!}
    {!! BootForm::hidden('path') !!}
    {!! BootForm::hidden('extension') !!}
    {!! BootForm::hidden('mimetype') !!}
    {!! BootForm::hidden('width') !!}
    {!! BootForm::hidden('height') !!}

    <div class="col-sm-6">
        {!! TranslatableBootForm::text(trans('validation.attributes.alt_attribute'), 'alt_attribute') !!}
        {!! TranslatableBootForm::textarea(trans('validation.attributes.description'), 'description') !!}
    </div>

    <div class="col-sm-6">

        @include('core::admin._file-fieldset', ['field' => 'file'])

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
                    <td>{{ $model->file }}</td>
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
