@extends('core::admin.master')

@section('title', __('Files'))

@section('content')

<div>
    <filepicker class="filepicker filepicker-editable" url-base="/admin/files"></filepicker>
</div>

@endsection
