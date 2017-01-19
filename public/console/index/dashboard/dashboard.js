(function () {
    var os = angular.module("app");

    os.controller('DashboardCtrl', ["$scope", function ($scope) {
        $scope.items = [];

        $scope.test = function () {
            for (var i=0; i<10; i++) {
                $scope.items.push({
                    name:"item"+i,
                    index:i
                })
            }
            console.log($scope.items)
        };

        $scope.test();
    }])
})();