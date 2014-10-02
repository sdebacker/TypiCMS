(function (angular) {

    angular.module('typicms').controller('ListController', ['$scope', '$location', '$api', '$http',

        function ($scope, $location, $api, $http) {

            $scope.itemsByPage = 25;
            $scope.url = $location.absUrl().split('?')[0];

            $scope.TypiCMS = TypiCMS;

            $api.query().$promise.then(function(all) {
                $scope.models = all;
                //copy the references (you could clone ie angular.copy but then have to go through a dirty checking for the matches)
                $scope.displayedModels = [].concat($scope.models);
            });

            $scope.toggleStatus = function(model) {
                var index = $scope.models.indexOf(model),
                    status = Math.abs(model.status - 1)
                    statuses = [
                        'offline',
                        'online'
                    ];
                model.status = status;
                $api.update({'id':model.id}, model).$promise.then(function() {
                    alertify.success('Item is ' + statuses[status] + '.');
                },
                function(reason) {
                    alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                });
            };

            $scope.toggleHomepage = function(model) {
                var index = $scope.models.indexOf(model),
                    homepage = Math.abs(model.homepage - 1);
                model.homepage = homepage;
                $api.update({'id':model.id}, model).$promise.then(function() {
                },
                function(reason) {
                    alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                });
            };

            $scope.changePosition = function(model) {
                var index = $scope.models.indexOf(model);
                $api.update({'id':model.id}, model).$promise.then(function() {
                },
                function(reason) {
                    alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                });
            };

            $scope.delete = function(model, title) {
                if (! title) {
                    title = model.title;
                }
                if (! confirm('Supprimer « ' + title + ' » ?')) {
                    return false;
                }
                var index = $scope.models.indexOf(model);
                $api.delete({'id':model.id}, function(model) {
                    if (index !== -1) {
                        $scope.models.splice(index, 1);
                    }
                });
            };

            var nested = function() {
                if ($('#tree-root').data('max-depth') > 1) {
                    return true;
                }
                return false;
            };

            $scope.treeOptions = {
                dragThreshold: 3,
                levelThreshold: 30,
                accept: function(sourceNodeScope, destNodesScope, destIndex) {
                    // console.log(sourceNodeScope.model);
                    return true;
                },
                dropped: function(event) {
                    var model = event.source.nodeScope.model,
                        parent = null,
                        parentId = 0,
                        nodes = event.dest.nodesScope,
                        currentList = nodes.$modelValue;
                    if (event.dest.nodesScope.$nodeScope) {
                        parentId = nodes.$nodeScope.model.id;
                    }

                    var data = {};

                    if (nested()) {
                        data['nested'] = true;
                    }

                    data['item'] = [];
                    // alert('ici');
                    model.parent = parentId;
                    model.position = event.dest.index + 1;
                    // console.log(currentList);

                    angular.forEach(currentList, function(model, key) {
                        // console.log(model.id);
                        data['item'].push({'id': model.id, 'position': key, 'parent': model.parent});
                        // model.position = key; 
                        // console.log(key, model);
                    });

                    $http.post($location.absUrl().split('?')[0] + '/sort', data).
                        error(function(data, status, headers, config) {
                            alertify.error('Error ' + status + ' ' + data.error.message);
                            // this callback will be called asynchronously
                            // when the response is available
                        });
                }
            };

        }

    ]);

})(angular);
