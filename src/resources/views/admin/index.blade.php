@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

@include('files::admin._filemanager')

@endsection
