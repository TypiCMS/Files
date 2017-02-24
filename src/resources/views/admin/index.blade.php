@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="FilesController">

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

    <div class="filemanager"
        dnd-list="models"
        dnd-horizontal-list="true"
        >
        <div class="filemanager-item"
            ng-repeat="model in models"
            ng-switch="model.type"
            id="item_@{{ model.id }}"
            ng-class="model.type == 'f' ? 'filemanager-item-folder' : 'filemanager-item-file'"
            lvl-draggable
            lvl-droppable
            x-on-drop="dropped(dragEl, dropEl)"
            >
            <div class="filemanager-item-icon" ng-switch-when="i">
                <img class="filemanager-item-image" ng-src="@{{ model.thumb_sm }}" alt="@{{ model.alt_attribute_translated }}">
            </div>
            <div class="filemanager-item-icon filemanager-item-icon-@{{ model.type }}" ng-switch-default></div>
            <div class="filemanager-item-name">@{{ model.name }}</div>
        </div>
    </div>

</div>

@endsection
