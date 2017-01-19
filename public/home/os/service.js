(function () {
    var app = angular.module('app');

    app.factory('appManager', ['$rootScope', '$location', '$log', function ($rootScope, $location, $log) {

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
            activate: activateApp
        };

        return service;
    }]);

})();