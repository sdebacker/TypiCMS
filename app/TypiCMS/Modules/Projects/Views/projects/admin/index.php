<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} projects">{{ models.length }} project</span>
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
                    <th st-sort="title" class="title st-sort" translate>Title</th>
                    <th st-sort="category_name" class="category st-sort" translate>Category</th>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>
                        <input st-search="'title'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'category_name'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model)"></typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td typi-btn-status></td>
                    <td typi-thumb-list-item></td>
                    <td>{{ model.title }}</td>
                    <td>{{ model.category_name }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="6" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
