(function () {
    var app = angular.module('app', ['ngRoute','oc.lazyLoad', 'ngTable']); //'ngJsTree','angularBootstrapNavTree',

    app.config(function ($routeProvider) {
        $routeProvider.otherwise(APPS[0].url);

        angular.forEach(APPS, function (app) {
            var route = {
                id         : app.url,
                icon       : app.icon,
                title      : app.title,
                templateUrl: app.templateUrl,
                resolve    : app.resolve
            };

            if (route.resolve && route.resolve.deps) {
                var deps = route.resolve.deps;
                route.resolve.deps = ['$ocLazyLoad', function($ocLazyLoad) {
                    return $ocLazyLoad.load({ name: 'app', files: deps }).then(function success(args) {
                        //console.debug(args);
                        return args;
                    }, function error(err) {
                        console.error(app.id);
                        console.error(err);
                        return err;
                    });
                }];
            }

            $routeProvider.when(app.url, route);
        });

    });

    app.run(['$rootScope', '$route', '$routeParams', '$location', '$log', 'appManager', function($rootScope, $route, $routeParams, $location, $log, appManager) {
        $rootScope.$route = $route;
        $rootScope.$routeParams = $routeParams;
        $rootScope.appManager = appManager;

        $rootScope.$on('$routeChangeStart', function(evt, next, current) {
            //$log.debug('>>>> $routeChangeStart');
            $('.pace .pace-progress').addClass('hide');
            $('.pace').removeClass('pace-inactive');
        });
    }]);

    app.controller('OsController', ['$scope', '$http', '$timeout', '$log', function($scope, $http, $timeout, $log){

    }]);

})();