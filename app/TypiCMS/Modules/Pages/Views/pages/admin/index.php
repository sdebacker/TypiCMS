<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate>Pages</span>
    </h1>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <!-- Nested node template -->
    <div ui-tree="treeOptions">
        <ul ui-tree-nodes="" data-max-depth="3" ng-model="models" id="tree-root">
            <li ng-repeat="model in models" ui-tree-node ng-include="'/views/partials/nodes_renderer.html'"></li>
        </ul>
    </div>

</div>
