@extends('core::admin.master')

@section('bodyClass')
@stop
@section('navbar')
@stop
@section('sidebar')
@stop
@section('mainClass')
col-xs-12
@stop
@section('breadcrumbs')
@stop

@section('h1')
    <span id="nb_elements">{{ $models->total() }}</span> @choice('files::global.files', $models->total())
@stop

@section('titleLeftButton')
@stop

@section('main')

    @include('files::admin.thumbnails')

@stop
