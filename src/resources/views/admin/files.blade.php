@if ($model->id)
<div ng-cloak ng-controller="FilesController" url="/admin/{{ $model->getTable() }}/{{ $model->id }}/files">
    <div class="filemanager" ng-sortable="sortableOptions" ng-click="unCheckAll()">
        <div class="filemanager-item filemanager-item-with-name filemanager-item-file filemanager-item-removable"
            ng-repeat="file in model.models"
            ng-switch="file.type"
            id="item_@{{ file.id }}"
            >
            <div class="filemanager-item-wrapper">
                <a class="filemanager-item-removable-button" ng-click="remove(file)" href="#"><span class="fa fa-times"></span></a>
                <div class="filemanager-item-icon" ng-switch-when="i">
                    <div class="filemanager-item-image-wrapper">
                        <img class="filemanager-item-image" ng-src="@{{ file.thumb_sm }}" alt="@{{ file.alt_attribute_translated }}">
                    </div>
                </div>
                <div class="filemanager-item-icon filemanager-item-icon-@{{ file.type }}" ng-switch-default></div>
                <div class="filemanager-item-name">@{{ file.name }}</div>
            </div>
        </div>
    </div>
</div>
@endif
