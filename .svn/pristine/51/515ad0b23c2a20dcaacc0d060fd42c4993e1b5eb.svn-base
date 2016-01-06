/**
 * Created by fengxiaofei on 2015/12/2.
 */
'use strict'
define([], function () {

    var quoteIndexModule = angular.module("quoteIndexModule", []);

    quoteIndexModule.controller('quoteIndexCtrl', ['$scope', '$request', 'blockUI', function ($scope, $request, blockUI) {
        $scope.result = [];
        $scope.getFee = function () {
            $request.get('getFee&country=US&weight=0.5', function (data) {
                $scope.result = data.transportFee;
            }, function (err) {
                alert(err);
            })
        }
    }]);
})