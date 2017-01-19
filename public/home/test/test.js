(function () {
    var os = angular.module('app');

    os.controller('TestCtrl', ['$scope', '$http', function ($scope, $http) {
        var vm = this;

        // vm.treeData = [];
        //
        // //angular.copy(vm.originalData,vm.treeData);
        //
        // vm.treeConfig = {
        //     core : {
        //         multiple : false,
        //         animation: 150,
        //         error : function(error) {
        //             $log.error('treeCtrl: error from js tree - ' + angular.toJson(error));
        //         },
        //         check_callback : true,
        //         worker : true
        //     },
        //     types : {
        //         default : {
        //             icon : 'fa fa-th'
        //         },
        //         "3" : {
        //             icon : 'fa fa-th'
        //         },
        //         "4" : {
        //             icon : 'fa fa-th-large'
        //         },
        //         "5" : {
        //             icon : 'fa fa-clone'
        //         },
        //         "6" : {
        //             icon : 'fa fa-cube'
        //         }
        //     },
        //     version : 1,
        //     plugins : ['types', 'wholerow'] //'checkbox',
        // };
        //
        // vm.ignoreChanges = false;
        // vm.applyModelChanges = function() {
        //     return !vm.ignoreChanges;
        // };
        //
        // $http.get("/console/test/tree").success(function(response) {
        //     vm.treeData = response;
        //     vm.ignoreChanges = true;
        //     vm.treeConfig.version++;
        // });
        //
        //
        // var onTreeReady = function() {
        //     if (vm.treeData.length == 0) return;
        //     $timeout(function(e, data) {
        //         vm.ignoreChanges = false;
        //         var jsTree = vm.treeInstance.jstree(true);
        //         jsTree.open_node(vm.treeData[0].id, null, false);
        //     });
        // };
        //
        // vm.selected = {};
        // var onTreeSelectNode= function(e,item) {
        //     var data = item.node.original;
        //     if (data.type == 6) {
        //         angular.copy(data, vm.selected);
        //         $scope.$apply();
        //         combo_hide();
        //     } else {
        //         var jsTree = vm.treeInstance.jstree(true);
        //         jsTree.toggle_node(item.node);
        //     }
        // };
        //
        // var onTreeCreateNode  = function(e, item) {
        //     $timeout(function() {
        //         $log.debug( 'Added new node with the text ' + item.node.text)
        //     });
        // };
        //
        // vm.treeEvents = {
        //     'ready': onTreeReady,
        //     'select_node': onTreeSelectNode,
        //     'create_node': onTreeCreateNode
        // };
        //
        // vm.comboTree = null;
        // vm.toggleTree = function(e) {
        //     var a = e.target;
        //     if (a.tagName == "I") a = a.parentElement;
        //     var t = a.parentElement.parentElement.parentElement;
        //
        //     var combo = angular.element(t);
        //     vm.comboTree = combo;
        //
        //     e.preventDefault();
        //     e.stopPropagation();
        //     combo_toggle(combo);
        // };
        //
        // var combo_show = function(combo) {
        //     combo.addClass('open');
        //     angular.element(window.document).on('mousedown', combo_hide);
        // };
        //
        // var combo_hide = function(e) {
        //     var combo = vm.comboTree;
        //     if (e) {
        //         if (combo.context.contains(e.target)) return;
        //     }
        //     combo.removeClass('open');
        //     angular.element(window.document).off('mousedown', combo_hide);
        // };
        //
        // var combo_toggle = function (combo) {
        //     if (combo.hasClass('open')) {
        //         combo_hide();
        //     } else {
        //         combo_show(combo);
        //     }
        // };


        $scope.access_token = window.sessionStorage.setItem('test', "test");
    }]);
})();