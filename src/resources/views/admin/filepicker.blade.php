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

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a id="uploaderAddButtonContainer" href="#"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">@{{ ucfirst(trans('files::global.New')) }}</span></a>
        <span>@{{ models.length }} @choice('files::global.files', 2)</span>
    </h1>

    <div class="dropzone hidden" drop-zone="" id="dropzone">
        <div class="dz-message">Click or drop files to upload.</div>
    </div>

    <div class="thumbnail" ng-repeat="model in models" id="item_@{{ model.id }}">
        <img class="img-responsive" ng-src="@{{ model.thumb_sm }}" alt="">
        <div class="caption">
            <a href="#" class="btn btn-default btn-xs btn-block btn-insert" ng-click="selectAndClose(<?php echo Input::get('CKEditorFuncNum') ?>, '/' + model.path + '/' + model.file)">Insert</a>
            <small>@{{ model.file }}</small>
        </div>
    </div>

</div>

@stop
