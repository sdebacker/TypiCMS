<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} tags">{{ models.length }} tag</span>
    </h1>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th st-sort="tag" class="tag st-sort" translate>Tag</th>
                    <th st-sort="uses" st-sort-default="reverse" class="uses st-sort" translate>Uses</th>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input st-search="'tag'" class="form-control" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td></td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model, model.tag)"></typi-btn-delete></td>
                    <td>{{ model.tag }}</td>
                    <td>{{ model.uses }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" typi-pagination></td>
                </tr>
            </tfoot>
        </table>

    </div>

</div>
