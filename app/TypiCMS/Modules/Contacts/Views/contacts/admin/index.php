<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} contacts">{{ models.length }} contact</span>
    </h1>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <div class="table-responsive">

        <table st-table="displayedModels" st-safe-src="models" st-order st-filter class="table table-condensed table-main">
            <thead>
                <tr>
                    <th class="delete"></th>
                    <th class="edit"></th>
                    <th st-sort="first_name" class="first_name st-sort" translate>First name</th>
                    <th st-sort="last_name" class="last_name st-sort" translate>Last name</th>
                    <th st-sort="email" class="email st-sort" translate>Email</th>
                    <th st-sort="message" class="message st-sort" translate>Message</th>
                </tr>
                <tr>
                    <td colspan="2"></td>
                    <td>
                        <input st-search="'first_name'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'last_name'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'email'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                    <td>
                        <input st-search="'message'" class="form-control input-sm" placeholder="{{ 'Search' | translate }}…" type="text">
                    </td>
                </tr>
            </thead>

            <tbody>
                <tr ng-repeat="model in displayedModels">
                    <td><typi-btn-delete ng-click="delete(model, model.title + ' ' + model.first_name + ' ' + model.last_name)"></typi-btn-delete></td>
                    <td typi-btn-edit></td>
                    <td>{{ model.first_name }}</td>
                    <td>{{ model.last_name }}</td>
                    <td>{{ model.email }}</td>
                    <td>{{ model.message }}</td>
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
