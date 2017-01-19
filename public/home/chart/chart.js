(function () {
    var os = angular.module('app');

    os.controller('ChartCtrl', ['$scope', '$http', 'NgTableParams', function ($scope, $http, NgTableParams) {
        var vm = this;

        $scope.items = [];

        console.log("totototo");
        $scope.wsl = function () {
            $http.get('/console/test/test').success(function (response) {
                $scope.items = response.data;
            });
        };

        $scope.wsl();

        var data = [];
        for (var i = 0; i < 70; i++) {
            data.push({name: "name" + i, age: i});
        }

        vm.tableParams = new NgTableParams({}, {
            counts: [],
            getData: function ($defer, params) {
                $http.get('/console/test/test').success(function (response) {
                    $defer.resolve(response.data);
                    params.total(response.data.length);
                });
            }
        });
    }]);
})();