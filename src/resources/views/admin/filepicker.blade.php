@extends('core::admin.master')

@section('bodyClass')
@endsection
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

@include('files::admin._filemanager')

@endsection
