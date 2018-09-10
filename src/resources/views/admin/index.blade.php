@extends('core::admin.master')

@section('title', __('Files'))

@section('content')

<div>
    <filepicker class="filepicker filepicker-editable" url-base="{{ route('api::index-files') }}"></filepicker>
</div>

@endsection
