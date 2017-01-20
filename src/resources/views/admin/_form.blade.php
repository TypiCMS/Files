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
    {!! BootForm::hidden('redirect_to_gallery')->value(request('redirect_to_gallery')) !!}

    <div class="col-sm-6">
        {!! TranslatableBootForm::text(__('validation.attributes.alt_attribute'), 'alt_attribute') !!}
        {!! TranslatableBootForm::textarea(__('validation.attributes.description'), 'description') !!}
    </div>

    <div class="col-sm-6">

        @include('core::admin._file-fieldset', ['field' => 'file'])

        <table class="table table-condensed">
            <thead>
                <th>{{ __('validation.attributes.file information') }}</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <th>{{ __('validation.attributes.path') }}</th>
                    <td>{{ $model->path }}</td>
                </tr>
                <tr>
                    <th>{{ __('validation.attributes.filename') }}</th>
                    <td>{{ $model->file }}</td>
                </tr>
                <tr>
                    <th>{{ __('validation.attributes.extension') }}</th>
                    <td>{{ $model->extension }}</td>
                </tr>
                <tr>
                    <th>{{ __('validation.attributes.mimetype') }}</th>
                    <td>{{ $model->mimetype }}</td>
                </tr>
                @if ($model->width)
                <tr>
                    <th>{{ __('validation.attributes.width') }}</th>
                    <td>{{ $model->width }} px</td>
                </tr>
                @endif
                @if ($model->height)
                <tr>
                    <th>{{ __('validation.attributes.height') }}</th>
                    <td>{{ $model->height }} px</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>

</div>
