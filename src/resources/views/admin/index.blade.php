@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

<div>
    @include('files::admin._filemanager', ['options' => ['editable']])
</div>

@endsection
