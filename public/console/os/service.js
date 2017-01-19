(function () {
    var app = angular.module('app');

    app.factory('appManager', ['$rootScope', '$location', '$log', '$controller', function ($rootScope, $location, $log, $controller) {

        var apps = [];
        apps.push({
            id: '/dashboard',
            title: '仪表盘',
            icon: 'fa fa-dashboard',
            templateLazy: 'dashboard/dashboard.html',
            sticky: true
        });

        var findApp = function (id) {
            for (var i = 0; i < apps.length; ++i) {
                if (apps[i].id == id) return apps[i];
            }
            return null;
        };

        var activateApp = function (app) {
            for (var i = 0; i < apps.length; ++i) {
                apps[i].active = false;
            }
            app.active = true;
            if (!app.templateUrl) app.templateUrl = app.templateLazy;
        };

        var closeApp = function (event, index) {
            event.preventDefault();
            event.stopPropagation();

            var app = apps[index];

            apps.splice(index, 1);

            if (app.active) {
                if (index > apps.length - 1)
                    app = apps[apps.length - 1];
                else
                    app = apps[index];
                $location.path(app.id);
            }
        };

        $rootScope.$on('$routeChangeStart', function (evt, next, current) {
            //$log.debug(next);

        });

        $rootScope.$on('$routeChangeSuccess', function (evt, current, previous) {
            var id = $location.path();
            var app = findApp(id);
            if (!app) {
                app = {
                    id: id,
                    icon: current.icon || 'fa fa-circle-thin',
                    title: current.title,
                    templateUrl: current.templateUrl
                };
                apps.push(app);
            }

            activateApp(app);
        });


        var service = {
            apps: apps,
            activate: activateApp,
            close: closeApp
        };

        return service;
    }]);
    
})();