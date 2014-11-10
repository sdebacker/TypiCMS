<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} partners">{{ models.length }} partner</span>
    </h1>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort" translate>Status</th>
                    <th st-sort="image" class="image st-sort" translate>Image</th>
                    <th st-sort="position" st-sort-default class="position st-sort" translate>Position</th>
                    <th st-sort="homepage" class="homepage st-sort">Home</th>
                    <th st-sort="title" class="title st-sort" translate>Title</th>
                    <th st-sort="website" class="website st-sort" translate>Website</th>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>
                        <input st-search="'title'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'website'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model)"></typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td typi-btn-status></td>
                    <td typi-thumb-list-item></td>
                    <td>
                        <input class="form-control input-sm" min="1" type="number" value="{{ model.position }}" name="position" ng-model="model.position" ng-change="update(model)">
                    </td>
                    <td>{{ model.homepage }}</td>
                    <td>{{ model.title }}</td>
                    <td>{{ model.website }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
