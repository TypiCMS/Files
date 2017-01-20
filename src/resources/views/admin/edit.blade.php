@extends('core::admin.master')

@section('title', $model->present()->title)

@section('main')

    <a class="btn-back" href="{{ request('redirect_to_gallery') ? route('admin::edit-gallery', [$model->gallery_id, 'tab' => 'tab-files']) : route('admin::index-files') }}" title="{{ __('files::global.Back') }}"><span class="text-muted fa fa-arrow-circle-left"></span><span class="sr-only">{{ __('files::global.Back') }}</span></a>
    <h1 class="@if(!$model->present()->title)text-muted @endif">
        {{ $model->present()->title ?: __('core::global.Untitled') }}
    </h1>

    {!! BootForm::open()->put()->action(route('admin::update-file', $model->id))->multipart()->role('form') !!}
    {!! BootForm::bind($model) !!}
        @include('files::admin._form')
    {!! BootForm::close() !!}

@endsection
