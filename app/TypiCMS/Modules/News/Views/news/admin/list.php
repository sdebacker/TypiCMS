<div class="list-form" ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="/admin/news/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only">{{ 'New' }}</span></a>
        <span id="nb_elements">{{ models.length }}</span>
        <span translate="NEWS" ng-show="models.length <= 1"></span>
        <span translate="NEWS_MANY" ng-show="models.length > 1"></span>
    </h1>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="status" class="status st-sort">{{ 'STATUS' | translate }}</th>
                    <th st-sort="date" st-sort-default="reverse" class="date st-sort">{{ 'DATE' | translate }}</th>
                    <th st-sort="image" class="image st-sort">{{ 'IMAGE' | translate }}</th>
                    <th st-sort="title" class="title st-sort">{{ 'TITLE' | translate }}</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <input st-search="'title'" class="form-control" placeholder="{{ 'SEARCH' | translate }}…" type="text">
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td>
                        <!-- Delete button -->
                        <div class="btn btn-xs btn-link" ng-click="delete(model)">
                            <span class="fa fa-remove"></span>
                            <span class="sr-only">{{ 'DELETE' | translate }}</span>
                        </div>
                    </td>
                    <td>
                        <!-- Edit button -->
                        <a class="btn btn-default btn-xs" href="/admin/news/{{ model.id }}/edit">{{ 'EDIT' | translate }}</a>
                    </td>
                    <td>
                        <!-- Online / Offline buttons -->
                        <div class="btn btn-xs btn-link" ng-click="toggleStatus(model)">
                            <span class="fa switch" ng-class="model.status == '1' ? 'fa-toggle-on' : 'fa-toggle-off'"></span>
                            <span class="sr-only" ng-show="model.status == '1'">{{ 'ONLINE' | translate }}</span>
                            <span class="sr-only" ng-hide="model.status == '0'">{{ 'OFFLINE' | translate }}</span>
                        </div>
                    </td>
                    <td>{{ model.date | dateFromMySQL:'short' }}</td>
                    <td>
                        <!-- Image -->
                        <img class="img-responsive" ng-src="{{ model.thumb }}" alt="">
                    </td>
                    <td>{{ model.title }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="8">
                        <div st-pagination="" st-items-by-page="itemsByPage" st-displayed-pages="9999"></div>
                    </td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
