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
                        <th st-sort="title" class="title st-sort" translate>Title</th>
                        <th st-sort="historable_table" class="historable_table st-sort" translate>Module</th>
                        <th st-sort="action" class="action st-sort" translate>Action</th>
                        <th st-sort="user_name" class="user_name st-sort" translate>User</th>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <input st-search="" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                        </td>
                    </tr>
                </thead>

                <tbody>
                    <tr ng-repeat="model in displayedModels">
                        <td>{{ model.created_at | dateFromMySQL:'short' }}</td>
                        <td>
                            <a ng-if="model.href" href="{{ model.href }}?locale={{ model.locale }}">{{ model.title }}</a>
                            <span ng-if="! model.href">{{ model.title }}</span>
                            <span ng-if="model.locale">({{ model.locale }})</span>
                        </td>
                        <td>{{ model.historable_table }}</td>
                        <td>
                            <span class="fa fa-fw {{ model.icon_class }}"></span> {{ model.action }}
                        </td>
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
