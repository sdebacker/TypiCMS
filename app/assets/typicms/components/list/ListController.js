(function (angular) {

    angular.module('typicms').controller('ListController', ['$scope', '$location','$api',

        function ($scope, $location, $api) {

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

        }

    ]);

})(angular);
