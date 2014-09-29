(function (angular) {

    var lang = $('html').attr('lang');

    angular.module('typicms', ['ngResource', 'smart-table', 'gettext'], function($locationProvider){
        // $locationProvider.html5Mode(true);
    });

    angular.module('typicms').run(function (gettextCatalog) {
        gettextCatalog.setCurrentLanguage(lang);
        gettextCatalog.loadRemote("/languages/" + lang + ".json");
        // gettextCatalog.debug = true;
    });

    angular.module('typicms').factory('$api', ['$location', '$resource', function($location, $resource) {
        // var moduleName = $location.path().split("/")[2]; // ok when in HTML5 route mode
        var url = $location.absUrl().split('?')[0];
        var moduleName = url.split('/')[4];
        return $resource('/api/v1/' + moduleName + '/:id', null,
            {
                'update': { method:'PUT' }
            });
        }]
    );

})(angular);
