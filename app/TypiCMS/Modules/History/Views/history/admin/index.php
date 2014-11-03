<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <div class="panel panel-default">

        <div class="panel-heading">
            <h2 class="panel-title" translate>Latest changes</h2>
        </div>

        <div class="table-responsive">

            <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
                <thead>
                    <tr>
                        <th st-sort="created_at" st-sort-default="reverse" class="created_at st-sort" translate>Date</th>
                        <th st-sort="action" class="action st-sort" translate>Action</th>
                        <th st-sort="historable_type" class="historable_type st-sort" translate>Type</th>
                        <th st-sort="historable_id" class="historable_id st-sort" translate>ID</th>
                        <th st-sort="user_name" class="user_name st-sort" translate>User</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input st-search="'action'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                        </td>
                        <td>
                            <input st-search="'historable_type'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                        </td>
                        <td>
                            <input st-search="'user_name'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="model in displayedModels">
                        <td>{{ model.created_at | dateFromMySQL:'short' }}</td>
                        <td>{{ model.action }}</td>
                        <td>{{ model.historable_type }}</td>
                        <td>{{ model.historable_id }}</td>
                        <td>{{ model.user_name }}</td>
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

</div>
