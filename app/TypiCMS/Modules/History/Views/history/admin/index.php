<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} items in history">{{ models.length }} item in history</span>
    </h1>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th st-sort="created_at" st-sort-default="reverse" class="created_at st-sort" translate>Date</th>
                    <th st-sort="user_id" class="user_id st-sort" translate>User</th>
                    <th st-sort="action" class="action st-sort" translate>Action</th>
                    <th st-sort="type" class="type st-sort" translate>Type</th>
                    <th st-sort="id" class="id st-sort" translate>ID</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input st-search="'user_id'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'action'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td>{{ model.created_at | dateFromMySQL:'short' }}</td>
                    <td>
                        <a href="mailto: {{ model.email }}">{{ model.name }}</a>
                    </td>
                    <td>{{ model.action }}</td>
                    <td>{{ model.historable_type }}</td>
                    <td>{{ model.historable_id }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
