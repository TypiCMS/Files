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

@include('files::admin._filemanager', ['options' => ['dropzoneHidden', request('addButton') ? 'addButton' : '']])

@endsection
