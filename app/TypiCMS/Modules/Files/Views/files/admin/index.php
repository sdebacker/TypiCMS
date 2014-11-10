<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a id="uploaderAddButtonContainer" href="#"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} files">{{ models.length }} file</span>
    </h1>

    <div class="dropzone" drop-zone="" id="dropzone">
        <div class="dz-message" translate>Click or drop files to upload.</div>
    </div>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="created_at" st-sort-default="reverse" class="created_at st-sort" translate>Date</th>
                    <th st-sort="type" class="type st-sort" translate>Type</th>
                    <th st-sort="image" class="image st-sort" translate>Image</th>
                    <th st-sort="filename" class="title st-sort" translate>Filename</th>
                    <th st-sort="alt_attribute" class="selected st-sort">Alt attribute</th>
                    <th st-sort="width" class="width st-sort" translate>Width</th>
                    <th st-sort="height" class="width st-sort" translate>Height</th>
                </tr>
                <tr>
                    <td colspan="5"></td>
                    <td>
                        <input st-search="'title'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'alt_attribute'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model, model.filename)"></typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td>{{ model.created_at | dateFromMySQL:'short' }}</td>
                    <td>{{ model.type }}</td>
                    <td typi-thumb-list-item></td>
                    <td>{{ model.filename }}</td>
                    <td contentEditable highlighter="model.alt_attribute" ng-model="model.alt_attribute" ng-blur="update(model)">
                        {{ model.alt_attribute }}
                    </td>
                    <td>{{ model.width }}</td>
                    <td>{{ model.height }}</td>
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
