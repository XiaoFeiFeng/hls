/**
 * Created by Administrator on 2016/1/11.
 */
'use strict'
define([], function () {

    angular.module("userLoginModule", [])
        .controller('userLoginCtrl', ['$scope', '$request', 'blockUI', '$data', '$ui', '$store',
            function ($scope, $request, blockUI, $data, $ui, $store) {
                $scope.checkImgSrc = "/admin/api/view/img.php";
                $scope.user = {};
                $scope.error = false;

                $scope.exchangeImg = function () {
                    $scope.checkImgSrc = "/admin/api/view/img.php?r=" + $data.randomStr(10);
                }

                $scope.login = function () {
                    var data = angular.copy($scope.user);
                    $request.post("api/?model=user&action=login&test=true", data, function (response) {
                        if (response.success) {
                            $store.setJson("user", response.data);
                            $ui.locate("../shipping/");
                        } else {
                            $scope.error = response.error;
                        }
                        $scope.checkImgSrc = "/admin/api/view/img.php?r=" + $data.randomStr(10);
                        $scope.user.checkimg = "";
                    }, function (err) {
                        $ui.error(err);
                        $scope.checkImgSrc = "/admin/api/view/img.php?r=" + $data.randomStr(10);
                        $scope.user.checkimg = "";
                    });

                }
            }]);
})