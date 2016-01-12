/**
 * Created by Administrator on 2016/1/11.
 */
'use strict'
define([], function () {

    angular.module("userLoginModule", [])

    .controller('userLoginCtrl', ['$scope', '$request', 'blockUI', '$data', '$ui',
        function ($scope, $request, blockUI, $data, $ui) {
            $scope.checkImgSrc = "http://www.93myb.com/admin/api/img.php";
            $scope.user = {};

            $scope.exchangeImg = function () {
                $scope.checkImgSrc = "http://www.93myb.com/admin/api/img.php?r=" + $data.randomStr(10);
            }

         /*   $scope.login = function () {
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
            }*/

        }]);
})