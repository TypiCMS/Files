@extends('core::admin.master')

@section('title', __('Files'))

@section('content')

<div>
    @include('files::admin._filemanager', ['options' => ['editable']])
</div>

@endsection
