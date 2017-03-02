<div ng-app="typicms" ng-cloak ng-controller="FilesController">

    <a id="uploaderAddButton" href="#" class="btn-add" title="{{ __('Add files') }}">
        <i class="fa fa-plus-circle"></i><span class="sr-only">{{ __('Add files') }}</span>
    </a>

    <h1>
        <span ng-repeat="folder in path">
            <a ng-if="!$last" href="#" ng-click="open(folder)">@{{ folder.name }}</a>
            <span ng-if="$last">@{{ folder.name }}</span>
            <span ng-if="!$last">/</span>
        </span>
    </h1>

    <div class="btn-toolbar">
        <button class="btn btn-default" ng-click="newFolder(folder.id)"><span class="fa fa-folder-o fa-fw"></span> {{ __('New folder') }}</button>
        <div class="btn-group dropdown">
            <button class="btn btn-default dropdown-toggle" ng-class="{disabled: !checked.models.length}" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                {{ __('Actions') }}
                <span class="caret"></span>
                <span class="fa fa-spinner fa-spin fa-fw" ng-show="loading"></span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                <li><a ng-click="deleteChecked()" href="#">{{ __('Delete') }}</a></li>
                <li ng-class="{disabled: !folder.id}"><a ng-click="moveToParentFolder()" href="#">{{ __('Move to parent folder') }}</a></li>
                <li role="separator" class="divider"></li>
                <li class="disabled"><a href="#">@{{ checked.models.length }} {{ __('items selected') }}</a></li>
            </ul>
        </div>
    </div>

    <div class="dropzone @if(in_array('dropzoneHidden', $options))hide @endif" dropzone id="dropzone" folder-id="@{{ folder.id }}">
        <div class="dz-message">{{ __('Click or drop files to upload') }}</div>
    </div>

    <div class="filemanager" ng-click="unCheckAll()">
        <div class="filemanager-item"
            ng-repeat="model in models"
            ng-switch="model.type"
            ng-click="check(model, $event)"
            id="item_@{{ model.id }}"
            ng-class="{
                'filemanager-item-selected': checked.models.indexOf(model) !== -1,
                'filemanager-item-folder': model.type == 'f',
                'filemanager-item-file': model.type != 'f',
            }"
            dragdrop
            checked-models="checked.models"
            on-drop="dropped(draggedModels, droppedModel)"
            ng-dblclick="model.type == 'f' ? open(model) : selectAndClose({{ request('CKEditorFuncNum', 0) }}, '/' + model.path + '/' + model.name)"
            >
            <div class="filemanager-item-wrapper">
                @if(in_array('editable', $options))
                <a class="filemanager-item-edit" href="/admin/files/@{{ model.id }}/edit"><span class="fa fa-pencil"></span></a>
                @endif
                <div class="filemanager-item-icon" ng-switch-when="i">
                    <img class="filemanager-item-image" ng-src="@{{ model.thumb_sm }}" alt="@{{ model.alt_attribute_translated }}">
                </div>
                <div class="filemanager-item-icon filemanager-item-icon-@{{ model.type }}" ng-switch-default></div>
                <div class="filemanager-item-name">@{{ model.name }}</div>
            </div>
        </div>
    </div>

</div>
