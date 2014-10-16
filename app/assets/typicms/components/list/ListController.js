(function (angular) {

    angular.module('typicms').controller('ListController', ['$scope', '$location','$api',

        function ($scope, $location, $api) {

            $scope.itemsByPage = 25;
            var url = $location.absUrl().split('?')[0];
            var moduleName = url.split('/')[4];
            var lastSegment = url.split('/').pop();
            $scope.url = url;
            $scope.parentId = $scope.url.split('/')[5] ? $scope.url.split('/')[5] : 0;
            if (moduleName == 'galleries' && lastSegment == 'edit') {
                $scope.url = '/admin/files';
            }


            $scope.TypiCMS = TypiCMS;

            // if we query files from a gallery, we need the gallery_id value :
            $params = {};
            if (url.split('/')[4] == 'galleries' && url.split('/')[5]) {
                $params.gallery_id = url.split('/')[5];
            }

            $api.query($params).$promise.then(function(all) {
                $scope.models = all;
                //copy the references (you could clone ie angular.copy but then have to go through a dirty checking for the matches)
                $scope.displayedModels = [].concat($scope.models);
            });

            /**
             * Set status = 0 or 1 for item
             */
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

            /**
             * Set homepage = 0 or 1 for item
             */
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

            /**
             * Change position of item
             */
            $scope.changePosition = function(model) {
                var index = $scope.models.indexOf(model);
                $api.update({'id':model.id}, model).$promise.then(function() {
                },
                function(reason) {
                    alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                });
            };

            /**
             * TinyMCE File picker
             */
            $scope.selectAndClose = function(file) {
                var TinyMCEWindow = top.tinymce.activeEditor.windowManager;
                TinyMCEWindow.getParams().oninsert(file);
                TinyMCEWindow.close();
            };

            /**
             * Delete an item
             */
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
