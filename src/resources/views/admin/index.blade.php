@extends('core::admin.master')

@section('title', trans('files::global.name'))

@section('main')

<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <a id="uploaderAddButtonContainer" href="#" class="btn-add" title="@lang('files::global.New')">
        <i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">@lang('files::global.New')</span>
    </a>

    <h1>
        <span>@{{ models.length }} @choice('files::global.files', 2)</span>
    </h1>

    <div class="dropzone" drop-zone="" id="dropzone">
        <div class="dz-message">@lang('files::global.Click or drop files to upload')</div>
    </div>

    <div class="btn-toolbar">
        @include('core::admin._lang-switcher')
    </div>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="created_at" st-sort-default="reverse" class="created_at st-sort">Date</th>
                    <th st-sort="type" class="type st-sort">Type</th>
                    <th class="image">Image</th>
                    <th st-sort="file" class="title st-sort">Filename</th>
                    <th st-sort="alt_attribute" class="selected st-sort">Alt attribute</th>
                    <th st-sort="width" class="width st-sort">Width</th>
                    <th st-sort="height" class="width st-sort">Height</th>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        <input st-search="file" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td>
                        <input st-search="alt_attribute" class="form-control input-sm" placeholder="@lang('global.Search')…" type="text">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete action="delete(model, model.file)"></td>
                    <td>
                        @include('core::admin._button-edit', ['module' => 'files'])
                    </td>
                    <td>@{{ model.created_at | dateFromMySQL:'short' }}</td>
                    <td>@{{ model.type }}</td>
                    <td ng-switch="model.type">
                        <img ng-switch-when="i" ng-src="@{{ model.thumb_src }}" alt="@{{ model.alt_attribute }}">
                        <span class="fa fa-fw fa-file-text-o" ng-switch-default></span>
                    </td>
                    <td>@{{ model.file }}</td>
                    <td>@{{ model.alt_attribute }}</td>
                    <td>@{{ model.width }}</td>
                    <td>@{{ model.height }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="9" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>

@endsection
