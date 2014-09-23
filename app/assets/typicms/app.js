(function (angular) {

    angular.module('typicms', ['ngResource', 'smart-table', 'pascalprecht.translate'], function($locationProvider){
        // $locationProvider.html5Mode(true);
    }).config(['$translateProvider', function ($translateProvider) {

        $translateProvider.translations('en', {
            'NEWS': 'news',
            'NEWS_MANY': 'news',
            'STATUS': 'Status',
            'DATE': 'Date',
            'IMAGE': 'Image',
            'TITLE': 'Title',
            'SEARCH': 'Search',
            'ONLINE': 'Online',
            'OFFLINE': 'Offline',
            'EDIT': 'Edit',
            'DELETE': 'Delete',
            'CREATE': 'Create',
        });

        $translateProvider.translations('fr', {
            'NEWS': 'actualité',
            'NEWS_MANY': 'actualités',
            'STATUS': 'Statut',
            'DATE': 'Date',
            'IMAGE': 'Image',
            'TITLE': 'Titre',
            'SEARCH': 'Chercher',
            'ONLINE': 'En ligne',
            'OFFLINE': 'Hors ligne',
            'EDIT': 'Modifier',
            'DELETE': 'Supprimer',
            'CREATE': 'Créer',
        });

        $translateProvider.preferredLanguage('fr');

    }]);

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
