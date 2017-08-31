@extends('core::admin.master')

@section('title', __('New file'))

@section('content')

    @include('core::admin._button-back', ['module' => 'files'])
    <h1>
        @lang('New file')
    </h1>

    {!! BootForm::open()->action(route('admin::index-files'))->multipart()->role('form') !!}
        @include('files::admin._form')
    {!! BootForm::close() !!}

@endsection
