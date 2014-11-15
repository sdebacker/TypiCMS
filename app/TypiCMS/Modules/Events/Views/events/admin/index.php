<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} events">{{ models.length }} event</span>
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
                    <th st-sort="start_date" st-sort-default="reverse" class="date st-sort" translate>Start date</th>
                    <th st-sort="end_date" st-sort-default="reverse" class="date st-sort" translate>End date</th>
                    <th st-sort="title" class="title st-sort" translate>Title</th>
                </tr>
                <tr>
                    <td colspan="6"></td>
                    <td>
                        <input st-search="'title'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model)"></typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td typi-btn-status></td>
                    <td typi-thumb-list-item></td>
                    <td>{{ model.start_date | dateFromMySQL:'short' }}</td>
                    <td>{{ model.end_date | dateFromMySQL:'short' }}</td>
                    <td>{{ model.title }}</td>
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
