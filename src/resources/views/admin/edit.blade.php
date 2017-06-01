@extends('core::admin.master')

@section('title', $model->present()->title)

@section('content')

    <a class="btn-back" href="{{ route('admin::index-files') }}" title="{{ __('Back to files list') }}"><span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ __('Back to files list') }}</span></a>
    <h1 class="@if (!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-file', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('files::admin._form')
    {!! BootForm::close() !!}

@endsection
