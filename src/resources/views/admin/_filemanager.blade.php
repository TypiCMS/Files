<div class="filepicker @foreach($options as $option) {{ 'filepicker-'.$option }} @endforeach" id="filepicker" ng-cloak ng-controller="FilesController" url="/admin/files">

    <div class="wrapper">

        <button class="filepicker-btn-close" id="close-filepicker"><span class="fa fa-close"></span></button>

        <a class="btn-add" id="uploaderAddButton" href="#" title="{{ __('Add files') }}">
            <i class="fa fa-plus-circle"></i><span class="sr-only">{{ __('Add files') }}</span>
        </a>

        <h1>
            <span ng-repeat="folder in path">
                <a ng-if="!$last" href="#" ng-click="handle(folder)">@{{ folder.name }}</a>
                <span ng-if="$last">@{{ folder.name }}</span>
                <span ng-if="!$last">/</span>
            </span>
        </h1>

        <div class="btn-toolbar">
            <button class="btn btn-default" ng-click="newFolder(folder.id)" type="button"><span class="fa fa-folder-o fa-fw"></span> {{ __('New folder') }}</button>
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
            <div class="btn-group">
                <button type="button" class="btn btn-default" ng-class="{active: view == 'grid'}" ng-click="switchView('grid')"><span class="fa fa-fw fa-th"></span> Grid</button>
                <button type="button" class="btn btn-default" ng-class="{active: view == 'list'}" ng-click="switchView('list')"><span class="fa fa-fw fa-bars"></span> List</button>
            </div>
        </div>

        <div class="dropzone" dropzone id="dropzone" folder-id="@{{ folder.id }}">
            <div class="dz-message">{{ __('Click or drop files to upload') }}</div>
        </div>

        <div class="filemanager" ng-click="unCheckAll()" ng-class="{'filemanager-list': view == 'list'}">
            <div class="filemanager-item filemanager-item-with-name filemanager-item-editable"
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
                ng-dblclick="handle(model)"
                >
                <div class="filemanager-item-wrapper">
                    <div class="filemanager-item-icon" ng-switch-when="i">
                        <div class="filemanager-item-image-wrapper">
                            <img class="filemanager-item-image" ng-src="@{{ model.thumb_sm }}" alt="@{{ model.alt_attribute_translated }}">
                        </div>
                    </div>
                    <div class="filemanager-item-icon filemanager-item-icon-@{{ model.type }}" ng-switch-default></div>
                    <div class="filemanager-item-name">@{{ model.name }}</div>
                    @if (in_array('editable', $options))
                    <a class="filemanager-item-editable-button" href="/admin/files/@{{ model.id }}/edit"><span class="fa fa-pencil"></span></a>
                    @endif
                </div>
            </div>
        </div>

        <button class="btn btn-success filepicker-btn-add btn-add-multiple" type="button" ng-click="addSelectedFiles()" id="btn-add-selected-files">{{ __('Add selected files') }}</button>
        <button class="btn btn-success filepicker-btn-add btn-add-single" ng-disabled="checked.models.length !== 1 || checked.models[0].type !== 'i'" type="button" ng-click="handle(checked.models[0])" id="btn-add-selected-file">{{ __('Add selected file') }}</button>

    </div>

</div>
