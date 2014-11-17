<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <div class="panel panel-default">

        <div class="panel-heading">
            <h2 class="panel-title" translate>Latest changes</h2>
        </div>

        <div class="table-responsive">

            <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
                <thead>
                    <tr>
                        <th class="created_at" translate>Date</th>
                        <th class="title" translate>Title</th>
                        <th class="historable_table" translate>Module</th>
                        <th class="action" translate>Action</th>
                        <th class="user_name" translate>User</th>
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
            </table>

        </div>

    </div>

</div>
