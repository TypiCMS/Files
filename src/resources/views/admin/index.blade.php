@extends('core::admin.master')

@section('title', __('files::global.name'))

@section('content')

<div ng-app="typicms" ng-cloak ng-controller="FilesController">

    <a id="uploaderAddButton" href="#" class="btn-add" title="@lang('files::global.New')">
        <i class="fa fa-plus-circle"></i><span class="sr-only">@lang('files::global.New')</span>
    </a>

    <h1>@lang('files::global.name')</h1>

    <div class="btn-toolbar">
        <div class="btn-group dropdown">
            <button class="btn btn-default dropdown-toggle" ng-class="{disabled: !checked.models.length}" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                Actions
                <span class="caret"></span>
                <span class="fa fa-spinner fa-spin fa-fw" ng-show="loading"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a ng-click="deleteChecked()" href="#">Delete</a></li>
                <li role="separator" class="divider"></li>
                <li class="disabled"><a href="#">@{{ checked.models.length }} items selected</a></li>
            </ul>
        </div>
        @include('core::admin._lang-switcher-for-list')
    </div>

    <div class="dropzone" dropzone id="dropzone">
        <div class="dz-message">@lang('files::global.Click or drop files to upload')</div>
    </div>

    <div class="filemanager">
        <div class="filemanager-item"
            ng-repeat="model in models"
            ng-switch="model.type"
            ng-click="toggleCheck(model)"
            id="item_@{{ model.id }}"
            ng-class="{
                'filemanager-item-selected': checked.models.indexOf(model) !== -1,
                'filemanager-item-folder': model.type == 'f',
                'filemanager-item-file': model.type != 'f',
            }"
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
