@extends('core::admin.master')

@section('bodyClass', 'body-filepicker')

@section('navbar')
@endsection
@section('sidebar')
@endsection
@section('mainClass')
col-xs-12
@endsection
@section('breadcrumbs')
@endsection

@section('titleLeftButton')
@endsection

@section('content')

<div>
    @include('files::admin._filemanager', ['options' => ['dropzoneHidden']])
</div>

@endsection
