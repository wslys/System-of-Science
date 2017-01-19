(function () {
    var app = angular.module('app', ['ngRoute','oc.lazyLoad']);

    // app.factory('appManager', ['$rootScope', '$location', '$log', '$controller', function($rootScope, $location, $log, $controller) {
    //
    //     var apps = [];
    //     apps.push({
    //         id: '/dashboard',
    //         title: '仪表盘',
    //         icon: 'fa fa-dashboard',
    //         templateLazy: 'dashboard/dashboard.html',
    //         sticky: true
    //     });
    //
    //     var findApp = function (id) {
    //         for (var i = 0; i < apps.length; ++i) {
    //             if (apps[i].id == id) return apps[i];
    //         }
    //         return null;
    //     };
    //
    //     var activateApp = function(app) {
    //         for (var i = 0; i < apps.length; ++i) {
    //             apps[i].active = false;
    //         }
    //         app.active = true;
    //         if (!app.templateUrl) app.templateUrl = app.templateLazy;
    //     };
    //
    //     var closeApp = function(event, index) {
    //         event.preventDefault();
    //         event.stopPropagation();
    //
    //         var app = apps[index];
    //
    //         apps.splice(index, 1);
    //
    //         if (app.active) {
    //             if (index > apps.length - 1)
    //                 app = apps[apps.length - 1];
    //             else
    //                 app = apps[index];
    //             $location.path(app.id);
    //         }
    //     };
    //
    //     $rootScope.$on('$routeChangeStart', function(evt, next, current) {
    //         //$log.debug(next);
    //
    //     });
    //
    //     $rootScope.$on('$routeChangeSuccess', function(evt, current, previous) {
    //         var id = $location.path();
    //         var app = findApp(id);
    //         if (!app) {
    //             app = {
    //                 id: id,
    //                 icon: current.icon||'fa fa-circle-thin',
    //                 title: current.title,
    //                 templateUrl: current.templateUrl
    //             };
    //             apps.push(app);
    //         }
    //
    //         activateApp(app);
    //     });
    //
    //
    //     var service = {
    //         apps: apps,
    //         activate: activateApp,
    //         close: closeApp
    //     };
    //
    //     return service;
    // }]);


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