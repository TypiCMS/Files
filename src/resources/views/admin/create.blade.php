@extends('core::admin.master')

@section('title', __('files::global.New'))

@section('content')

    @include('core::admin._button-back', ['module' => 'files'])
    <h1>
        @lang('files::global.New')
    </h1>

    {!! BootForm::open()->action(route('admin::index-files'))->multipart()->role('form') !!}
        @include('files::admin._form')
    {!! BootForm::close() !!}

@endsection
