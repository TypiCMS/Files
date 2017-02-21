@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <a id="uploaderAddButton" href="#" class="btn-add" title="@lang('files::global.New')">
        <i class="fa fa-plus-circle"></i><span class="sr-only">@lang('files::global.New')</span>
    </a>

    <h1>@lang('files::global.name')</h1>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher-for-list')
    </div>

    <div class="dropzone" dropzone id="dropzone">
        <div class="dz-message">@lang('files::global.Click or drop files to upload')</div>
    </div>

    <div class="filemanager">
        <div class="filemanager-item" ng-repeat="model in models" id="item_@{{ model.id }}" ng-class="model.type == 'f' ? 'filemanager-item-folder' : 'filemanager-item-file'">
            <div ng-switch="model.type">
                <img ng-switch-when="i" width="130" height="130" ng-src="@{{ model.thumb_sm }}" alt="@{{ model.alt_attribute }}">
                <div class="filemanager-item-type filemanager-item-type-@{{ model.type }}" ng-switch-default>
                    <div class="filemanager-item-name">@{{ model.name }}</div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
