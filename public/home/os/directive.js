(function () {
    var app = angular.module('app');

    app.directive('sidebar', function () {
        return {
            restrict: 'E',
            replace: true,
            transclude: true,
            scope : {
                sidebars : '=sidebarNav'
            },
            templateUrl: 'os/directiveTemp.html',
            controller: function () {
                var expanders = [];
                this.gotOpened = function (selectedExpander) {
                    angular.forEach(expanders, function (expander) {
                        if (selectedExpander != expander) {
                            expander.showMe = false;
                        }
                    });
                };
                this.addExpander = function (expander) {
                    expanders.push(expander);
                }
            },
            link : function (scope, element, attrs) {
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
            }
        }
    });

})();