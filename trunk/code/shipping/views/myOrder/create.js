/**
 * Created by fengxiaofei on 2016/1/29.
 */
'use strict'
define([], function () {

    angular.module("myOrderCreateModule", [])

        .controller('myOrderCreateCtrl', ['$scope', '$ui', function ($scope, $ui) {
            $scope.result = [];

            $scope.totalItems = 175;
            $scope.currentPage = 1;

            $scope.pageChange = function () {
                $scope.changedPage = $scope.currentPage;
            }
        }]);
})