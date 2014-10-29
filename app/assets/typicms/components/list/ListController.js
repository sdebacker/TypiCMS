(function (angular) {

    'use strict';

    /*jslint browser: true*/
    /*globals $, jQuery, angular, TypiCMS, alertify, top*/

    angular.module('typicms').controller('ListController', ['$http', '$scope', '$location', '$api',

        function ($http, $scope, $location, $api) {

            $scope.itemsByPage = 25;
            var url = $location.absUrl().split('?')[0],
                moduleName = url.split('/')[4],
                lastSegment = url.split('/').pop(),
                $params = {};
            $scope.url = url;
            $scope.parentId = $scope.url.split('/')[5] || 0;
            if (moduleName === 'galleries' && lastSegment === 'edit') {
                $scope.url = '/admin/files';
            }


            $scope.TypiCMS = TypiCMS;

            // if we query files from a gallery, we need the gallery_id value :
            if (moduleName === 'galleries' && url.split('/')[5]) {
                $params.gallery_id = url.split('/')[5];
            }

            // if we query menulinks menu_id value :
            if (url.split('/')[4] === 'menus' && url.split('/')[5]) {
                $params.menu_id = url.split('/')[5];
            }

            $api.query($params).$promise.then(function (all) {
                $scope.models = all;
                //copy the references (you could clone ie angular.copy but then have to go through a dirty checking for the matches)
                $scope.displayedModels = [].concat($scope.models);
            });

            /**
             * Set status = 0 or 1 for item
             */
            $scope.toggleStatus = function (model) {
                var status = Math.abs(model.status - 1),
                    statuses = [
                        'offline',
                        'online'
                    ];
                model.status = status;
                $api.update({'id': model.id}, model).$promise.then(
                    function () {
                        alertify.success('Item is ' + statuses[status] + '.');
                    },
                    function (reason) {
                        alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                    }
                );
            };

            /**
             * Set homepage = 0 or 1 for item
             */
            $scope.toggleHomepage = function (model) {
                model.homepage = Math.abs(model.homepage - 1);
                $api.update({'id': model.id}, model).$promise.then(
                    function () {
                    },
                    function (reason) {
                        alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                    }
                );
            };

            /**
             * Change position of item
             */
            $scope.changePosition = function (model) {
                $api.update({'id': model.id}, model).$promise.then(
                    function () {
                    },
                    function (reason) {
                        alertify.error('Error ' + reason.status + ' ' + reason.statusText);
                    }
                );
            };

            /**
             * TinyMCE File picker
             */
            $scope.selectAndClose = function (file) {
                var TinyMCEWindow = top.tinymce.activeEditor.windowManager;
                TinyMCEWindow.getParams().oninsert(file);
                TinyMCEWindow.close();
            };

            /**
             * Delete an item
             */
            $scope.delete = function (model, title) {
                if (!title) {
                    title = model.title;
                }
                if (!window.confirm('Supprimer « ' + title + ' » ?')) {
                    return false;
                }
                var index = $scope.models.indexOf(model);
                $api.delete({'id': model.id}, function () {
                    if (index !== -1) {
                        $scope.models.splice(index, 1);
                    }
                });
            };

            $scope.treeOptions = {
                dragThreshold: 3,
                levelThreshold: 30,
                dropped: function (event) {
                    var model = event.source.nodeScope.model,
                        parentId = 0,
                        nodes = event.dest.nodesScope,
                        currentList = nodes.$modelValue;

                    // if there is a parent
                    if (event.dest.nodesScope.$nodeScope) {
                        parentId = nodes.$nodeScope.model.id;
                    }

                    var data = {};
                    data['moved'] = model.id;
                    data['item'] = [];
                    if (moduleName === 'menulinks') {
                        model.menulink_id = parentId;
                    }
                    if (moduleName === 'pages') {
                        model.page_id = parentId;
                    }
                    model.position = event.dest.index + 1;

                    angular.forEach(currentList, function(model, key) {
                        data['item'].push({'id': model.id, 'page_id': model.page_id});
                    });

                    $http.post('/admin/' + moduleName + '/sort', data).
                        success(function(data, status, headers, config) {
                            alertify.success(data.message);
                        }).
                        error(function(data, status, headers, config) {
                            console.log(data);
                            alertify.error(data.error.message);
                        });

                }
            };

        }]);

})(angular);
