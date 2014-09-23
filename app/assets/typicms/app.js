(function (angular) {

    angular.module('typicms', ['ngResource', 'smart-table'], function($locationProvider){
        // $locationProvider.html5Mode(true);
    });

    var statuses = [
        'offline',
        'online'
    ];

    angular.module('typicms').factory('$api', ['$location', '$resource', function($location, $resource) {
        // var moduleName = $location.path().split("/")[2]; // ok when in HTML5 route mode
        var moduleName = $location.absUrl().split("/")[4];
        return $resource('/api/v1/' + moduleName + '/:id', null,
            {
                'update': { method:'PUT' }
            });
        }]
    );

})(angular);
