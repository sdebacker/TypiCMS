<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only">{{ 'NEW' | translate }}</span></a>
        <span translate="{{ models.length <= 1 ? 'NEWS' : 'NEWS_MANY' }}" translate-values="{value:models.length}"></span>
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
                    <td colspan="5"></td>
                    <td>
                        <input st-search="'title'" class="form-control" placeholder="{{ 'SEARCH' | translate }}…" type="text">
                    </th>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td typi-btn-status></td>
                    <td>{{ model.date | dateFromMySQL:'short' }}</td>
                    <td typi-thumb-list-item></td>
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
