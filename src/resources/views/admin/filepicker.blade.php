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

@section('main')

<div class="container-filepicker" ng-app="typicms" ng-cloak ng-controller="ListController">

    <a id="uploaderAddButtonContainer" href="#" class="btn-add"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">@{{ ucfirst(trans('files::global.New')) }}</span></a>
    <h1>
        <span>{{ ucfirst(trans_choice('files::global.files', 2)) }}</span>
    </h1>

    <div class="dropzone hidden" drop-zone="" id="dropzone">
        <div class="dz-message">@lang('files::global.Click or drop files to upload')</div>
    </div>

    <div class="row">
        <div class="thumbnail" ng-repeat="model in models" id="item_@{{ model.id }}">
            <div class="btn-insert" ng-switch="model.type" ng-click="selectAndClose(<?php echo Request::input('CKEditorFuncNum') ?>, '/' + model.path + '/' + model.file)">
                <img class="img-responsive" ng-switch-when="i" ng-src="@{{ model.thumb_sm }}" alt="@{{ model.alt_attribute }}">
                <div class="container-doc" ng-switch-default>
                    <div class="doc-info">
                        <span class="fa fa-3x fa-fw fa-file-o"></span>
                        @{{ model.file }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! $models->appends(Request::except('page'))->render() !!}

</div>

@endsection
