(function(angular) {

    var statuses = [
        'offline',
        'online'
    ];

    var typicms = angular.module('typicms', ['ngResource', 'smart-table'],function($locationProvider){
        $locationProvider.html5Mode(true);
    });

    // Tell smart-table to use betterOrderBy function in place of angular default
    angular.module('smart-table').directive('stOrder', ['$parse', function ($parse) {
        return {
            require: '^stTable',
            link: {
                pre: function (scope, element, attrs, ctrl) {
                    ctrl.setSortFunction('betterOrderBy');
                }
            }
        };
    }]);

    // http://stackoverflow.com/questions/14493168/fix-angular-sorting
    typicms.filter('betterOrderBy', function(orderByFilter) {
        return function(input, arg1, arg2) {

            if (! input[0]) {
                return orderByFilter(input, arg1, arg2);
            }
            
            var copy_of_input = angular.copy(input);

            for (var i = 0; i < input.length; i++) {
                copy_of_input[i]['orig'] = input[i];

                if (typeof(input[i][arg1]) == 'string' || input[i][arg1] instanceof String) {
                    copy_of_input[i][arg1] = normalize(copy_of_input[i][arg1]);
                }
            }
            var normalized_sorted = orderByFilter(copy_of_input, arg1, arg2);
            var normalized_sorted_orig = [];
            angular.forEach(normalized_sorted, function(obj, i) {
                normalized_sorted_orig.push(obj.orig)
            })
            return normalized_sorted_orig;
        }
    });

    // Tell smart-table to use betterFilter function in place of angular default
    angular.module('smart-table').directive('stFilter', ['$timeout', function ($timeout) {
        return {
            require: '^stTable',
            link: {
                pre: function (scope, element, attrs, ctrl) {
                    ctrl.setFilterFunction('betterFilter');
                }
            }
        };
    }]);

    typicms.filter('betterFilter', function(filterFilter) {
        return function(input, expression, comparator) {

            for (var index in expression) {
                expression[index] = normalize(expression[index]);
            }


            var copy_of_input = angular.copy(input);

            for (var i = 0; i < input.length; i++) {
                for (var index in input[i]) {
                    if (typeof(input[i][index]) == 'string' || input[i][index] instanceof String) {
                        copy_of_input[i][index] = normalize(input[i][index]);
                    }
                }
                copy_of_input[i]['orig'] = input[i];
            }
            var normalized_filtered = filterFilter(copy_of_input, expression, comparator);
            console.log(normalized_filtered);
            var normalized_filtered_orig = [];
            angular.forEach(normalized_filtered, function(obj, i) {
                normalized_filtered_orig.push(obj.orig)
            })
            return normalized_filtered_orig;
        }
    });

    typicms.factory('API', ['$location', '$resource', function($location, $resource) {
        var moduleName = $location.path().split("/")[2];
        return $resource('/api/v1/' + moduleName + '/:id', null,
            {
                'update': { method:'PUT' }
            });
        }]
    );

    function normalize(str) {
        str = str.toLowerCase();
        str = str.replace(/\\s/g, "");
        str = str.replace(/[àáâãäå]/g, "a");
        str = str.replace(/æ/g, "ae");
        str = str.replace(/’/g, "'");
        str = str.replace(/[“”«»]/g, "");
        str = str.replace(/ç/g, "c");
        str = str.replace(/[èéêë]/g, "e");
        str = str.replace(/[ìíîï]/g, "i");
        str = str.replace(/ñ/g, "n");
        str = str.replace(/[òóôõö]/g, "o");
        str = str.replace(/œ/g, "oe");
        str = str.replace(/[ùúûü]/g, "u");
        str = str.replace(/[ýÿ]/g, "y");
        str = str.replace(/\\W/g, "");
        return str.trim();
    }

    function ModelsController($scope, API) {

        $scope.itemsByPage = 50;

        API.query().$promise.then(function(all) {
            $scope.models = all;
            //copy the references (you could clone ie angular.copy but then have to go through a dirty checking for the matches)
            $scope.displayedModels = [].concat($scope.models);
            angular.forEach($scope.displayedModels, function (item) {
                item.date = new Date(item.date.replace(/-/g, '/'));
            });
        });

        $scope.toggleStatus = function(model) {
            var index = $scope.models.indexOf(model),
                status = Math.abs(model.status - 1);
            model.status = status;
            API.update({'id':model.id}, model).$promise.then(function() {
                alertify.success('Item is ' + statuses[status] + '.');
            },
            function(reason) {
                alertify.error('Error ' + reason.status + ' ' + reason.statusText);
            });
        };

        $scope.delete = function(model) {
            if (! confirm('Supprimer « ' + model.title + ' » ?')) { return false; };
            var index = $scope.models.indexOf(model);
            API.delete({'id':model.id}, function(model) {
                if (index !== -1) {
                    $scope.models.splice(index, 1);
                }
            });
        };

    }

    typicms.controller('ModelsController', ['$scope', 'API', ModelsController]);

})(angular);
