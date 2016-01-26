'use strict'

define([], function () {
    angular.module('merchantCompanyDetailModule', [])
        .controller("merchantCompanyDetailCtrl", ['$scope', '$request', '$ui', '$modalInstance', 'modalData',
            function ($scope, $request, $ui, $modalInstance, modalData) {

                $scope.merchant = modalData;

                $scope.getImage = function (path) {
                    return "http://93myb.com/" + path;
                }
                $scope.cancel = function () {
                    $modalInstance.close();
                }
                $scope.openImage = function (path) {
                    window.open("http://93myb.com/" + path);
                }
                $scope.submitForm = function (state) {
                    var confirmMsg = state == 1 ? "确认通过审核" : "确认拒绝通过";
                    $ui.confirm(confirmMsg, function () {
                        var data = angular.copy($scope.merchant);
                        data.state = state;
                        delete data.companyScale;
                        delete data._id;
                        delete data.$checked;

                        $request.post('api/?model=merchant&action=edit&id=' + $scope.merchant._id.$id,
                            data,
                            function (response) {
                                if (response.success) {
                                    $ui.notify('提交成功！', '提示',
                                        function () {
                                            $modalInstance.close(true);
                                        })
                                } else if (angular.isUndefined(response.success)) {
                                    $ui.error(response);
                                } else {
                                    $ui.error(response.error);
                                }
                            }, function (err) {
                                $ui.error('提交失败，' + err, '错误');
                            });
                    }, function () {
                        return false;
                    });
                }
            }
        ])

})