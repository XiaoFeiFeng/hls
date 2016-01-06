/**
 * Created by fengxiaofei on 2015/12/2.
 */
'use strict'
define([], function () {

    angular.module("newsIndexModule", [])

        .controller('newsIndexCtrl', ['$scope', '$request', 'blockUI', function ($scope, $request, blockUI) {
            $scope.result = [];
            $scope.getFee = function () {
                $request.get('data/index.php?action=getFee&country=US&weight=0.5', function (data) {
                    $scope.result = data.transportFee;
                }, function (err) {
                    alert(err);
                })
            }

            $scope.totalItems = 175;
            $scope.currentPage = 1;

            $scope.pageChange = function () {
                $scope.changedPage = $scope.currentPage;
            }
        }]);
})