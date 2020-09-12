@component('core::admin._buttons-form', ['model' => $model])
@endcomponent

<div class="row">


    @if ($model->gallery_id)
    {!! BootForm::hidden('gallery_id') !!}
    @endif
    {!! BootForm::hidden('type') !!}
    {!! BootForm::hidden('position')->value($model->position ?: 0) !!}
    {!! BootForm::hidden('path') !!}
    {!! BootForm::hidden('extension') !!}
    {!! BootForm::hidden('mimetype') !!}
    {!! BootForm::hidden('width') !!}
    {!! BootForm::hidden('height') !!}

    <div class="col-lg-6">

    @if ($model->type === 'i')
    {!! TranslatableBootForm::text(__('Alt attribute'), 'alt_attribute') !!}
    @endif

    {!! BootForm::text(__('Name'), 'name') !!}
    {!! TranslatableBootForm::textarea(__('Legend'), 'description') !!}

    @if ($model->type !== 'f')
        <table class="table table-sm table-striped">
            <tbody>
                <tr>
                    <th class="w-25">{{ __('URL') }}</th>
                    <td>
                        <div class="d-flex align-items-start justify-content-between">
                            <a href="{{ Storage::url($model->path) }}" target="_blank" rel="noopener noreferrer">{{ Storage::url($model->path) }}</a>
                            <button class="btn btn-secondary btn-xs text-nowrap" type="button" onclick="copyToClipboard('{{ Storage::url($model->path) }}')"><span class="fa fa-clipboard" aria-hidden="true"></span> @lang('Copy')</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>{{ __('Path') }}</th>
                    <td>{{ $model->path }}</td>
                </tr>
                <tr>
                    <th>{{ __('Name') }}</th>
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
    @endif

    </div>

    <div class="col-lg-6">
        @if ($model->type === 'i')
            <img class="img-fluid" src="{{ Storage::url($model->path) }}" alt="">
        @endif
    </div>

</div>
@push('js')
<script>
    function copyToClipboard(content) {
        var textArea = document.createElement('textarea');
        textArea.value = content;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('Copy');
        textArea.remove();
        alertify.success('@lang('Copied to the clipboard')');
    }
</script>
@endpush
