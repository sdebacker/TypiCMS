<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <div class="dropzone" drop-zone="" id="dropzone">
        <div class="dz-message">Click or drop files to upload.</div>
    </div>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <div class="table-responsive">

        <div class="thumbnail" ng-repeat="model in models" id="item_{{ model.id }}">
            <img class="img-responsive" ng-src="{{ model.thumb_sm }}" alt="">
            <div class="caption">
                <small>{{ model.filename }}</small>
            </div>
        </div>

    </div>

</div>
