<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a id="uploaderAddButtonContainer" href="#"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} files">{{ models.length }} file</span>
    </h1>

    <div class="dropzone hidden" drop-zone="" id="dropzone">
        <div class="dz-message" translate>Click or drop files to upload.</div>
    </div>

    <div class="thumbnail" ng-repeat="model in models" id="item_{{ model.id }}">
        <img class="img-responsive" ng-src="{{ model.thumb_sm }}" alt="">
        <div class="caption">
            <a href="#" class="btn btn-default btn-xs btn-block btn-insert" ng-click="selectAndClose('/' + model.path + model.filename)" translate>Insert</a>
            <small>{{ model.filename }}</small>
        </div>
    </div>

</div>
