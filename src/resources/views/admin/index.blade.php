@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

<div ng-app="typicms">
    @include('files::admin._filemanager', ['options' => ['editable']])
</div>

@endsection
