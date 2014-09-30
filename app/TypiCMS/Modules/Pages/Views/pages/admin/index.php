<div ng-app="typicms" ng-cloak ng-controller="ListController">

    <h1>
        <a href="{{ url }}/create" class="btn-add"><i class="fa fa-plus-circle"></i><span class="sr-only" translate>New</span></a>
        <span translate translate-n="models.length" translate-plural="{{ models.length }} pages">{{ models.length }} page</span>
    </h1>

    <div class="btn-toolbar" role="toolbar" ng-include="'/views/partials/btnLocales.html'"></div>

    <!-- Nested node template -->
    <script type="text/ng-template" id="nodes_renderer.html">
        <span typi-btn-delete></span>
        <span typi-btn-edit></span>
        <span typi-btn-status></span>
        <div ui-tree-handle>
            {{model.title}}
        </div>
        <ul ui-tree-nodes="" ng-model="model.children">
            <li ng-repeat="model in model.children" ui-tree-node ng-include="'nodes_renderer.html'">
            </li>
        </ul>
    </script>
    <div ui-tree>
        <ul ui-tree-nodes="" ng-model="models" id="tree-root">
            <li ng-repeat="model in models" ui-tree-node ng-include="'nodes_renderer.html'"></li>
        </ul>
    </div>

</div>
