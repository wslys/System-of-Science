(function () {
    var os = angular.module('app');

    os.controller('TableCtrl', ['$scope', 'NgTableParams', function ($scope, NgTableParams) {
        var vm = this;
        var data = [];
        for (var i=0; i<70; i++) {
            data.push({name:"name"+i, age:i});
        }
        vm.tableParams = new NgTableParams({}, { dataset: data});
    }]);
})();