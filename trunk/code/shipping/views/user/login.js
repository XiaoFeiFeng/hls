/**
 * Created by fengxiaofei on 2016/1/7.
 */
'use strict'
define([], function () {

    var quoteIndexModule = angular.module("userLoginModule", []);

    quoteIndexModule.controller('userLoginCtrl', ['$scope', '$request', 'blockUI', '$data', '$ui',
        function ($scope, $request, blockUI, $data, $ui) {

            $scope.checkImgSrc = "http://www.93myb.com/admin/data/img2.php";
            $scope.user = {};

            $scope.checkImgChange = function () {
                $scope.checkImgSrc = "http://www.93myb.com/admin/data/img2.php?r=" + $data.randomStr(10);
            }

            $scope.login = function () {
                $request.post('admin/data/?action=login',
                    $scope.user,
                    function (response) {
                        if (response.success) {
                            $ui.notify(response.data);
                        } else if (angular.isUndefined(response.success)) {
                            $ui.error(response);
                        } else {
                            $ui.error(response.error);
                        }

                    }, function (err) {
                        $ui.error('添加失败，' + err, '错误');
                    });
            }

        }]);
})