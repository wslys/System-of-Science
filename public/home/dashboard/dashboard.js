(function () {
    var os = angular.module("app");
    console.log("gogogogog");


    os.controller('DashboardCtrl',['$scope', '$http', function ($scope, $http) {
        $scope.items = [];
        console.log("totototo");
        $scope.wsl = function () {
            $http.get('/console/test/test').success(function (response) {
                $scope.items = response.data;
            });
        };

        $scope.wsl();
    }]);

})();