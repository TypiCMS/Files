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
        @if ($model->type === 'i')
        {!! TranslatableBootForm::text(__('Alt attribute'), 'alt_attribute') !!}
        @endif
        @if ($model->type === 'f')
        {!! BootForm::text(__('Name'), 'name') !!}
        @endif
        {!! TranslatableBootForm::textarea(__('Description'), 'description') !!}
    </div>

    @if ($model->type !== 'f')
    <div class="col-sm-6">

        <table class="table table-condensed">
            <thead>
                <th>{{ __('File information') }}</th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <th>{{ __('Path') }}</th>
                    <td>{{ $model->path }}</td>
                </tr>
                <tr>
                    <th>{{ __('Filename') }}</th>
                    <td>{{ $model->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('Extension') }}</th>
                    <td>{{ $model->extension }}</td>
                </tr>
                <tr>
                    <th>{{ __('Mimetype') }}</th>
                    <td>{{ $model->mimetype }}</td>
                </tr>
                @if ($model->width)
                <tr>
                    <th>{{ __('Width') }}</th>
                    <td>{{ $model->width }} px</td>
                </tr>
                @endif
                @if ($model->height)
                <tr>
                    <th>{{ __('Height') }}</th>
                    <td>{{ $model->height }} px</td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>
    @endif

</div>
