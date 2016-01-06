
'use strict'
define([], function () {
    angular.module('logistricCreateModule', [])
        .controller("logisticaddProTplCtrl", ['$scope', '$ui', function ($scope, $ui) {
            $scope.submitFlag = true;

            $scope.reset = function () {
                $scope.submitFlag = true;
            }

            $scope.$watch('flag', function (newValue) {
                if (newValue != undefined) {
                    if (newValue.name && newValue.code)
                        $scope.submitFlag = false;
                }
            }, true);

            $scope.submitForm = function () {
                $.ajax({
                    type: 'POST',
                    url: 'http://www.cpowersoft.com:8888/logist/logistic/logistic',
                    data: {
                        "name": $scope.flag.name,
                        "code": $scope.flag.code
                    },
                    dataType: 'html',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    success: function (data) {
                        if (data == 'OK') {
                            $ui.notify('添加成功', '提示');
                            $scope.flag = {};
                        }
                    }
                })
            }

        }])
})
