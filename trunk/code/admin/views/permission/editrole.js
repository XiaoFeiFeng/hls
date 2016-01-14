'use strict'
define([], function () {
    angular.module('permissionEditRoleModule', [])
        .controller("permissionEditRoleCtrl", ['$scope', '$ui', '$validate', '$request', '$modalInstance', 'modalData',
            function ($scope, $ui, $validate, $request, $modalInstance, modalData) {

                $scope.role = {};
                if (!$validate.isEmpty(modalData) && !$validate.isEmpty(modalData._id)) {
                    $scope.role = modalData;
                    $scope.isEdit = true;
                }
                $scope.submitForm = function () {
                    if ($scope.isEdit) {
                        var data = angular.copy($scope.role);
                        delete data._id;
                        delete data.$checked;
                        $request.post('api/?action=edit_role&id=' + $scope.role._id.$id,
                            data,
                            function (response) {
                                if (response.success) {
                                    $ui.notify('保存成功！', '提示',
                                        function () {
                                            $modalInstance.close(true);
                                        })
                                } else if (angular.isUndefined(response.success)) {
                                    $ui.error(response);
                                } else {
                                    $ui.error(response.error);
                                }
                            }, function (err) {
                                $ui.error('添加失败，' + err, '错误');
                            });
                    } else {
                        $request.post('api/?action=add_role',
                            $scope.role,
                            function (response) {
                                if (response.success) {
                                    $ui.confirm('添加成功，是否继续添加?', '确认',
                                        function () {
                                            $scope.reset()
                                            $scope.isAdded = true;
                                        },
                                        function () {
                                            $modalInstance.close(true);
                                        })
                                } else if (angular.isUndefined(response.success)) {
                                    $ui.error(response);
                                } else {
                                    $ui.error(response.error);
                                }

                            }, function (err) {
                                $ui.error('添加失败，' + err, '错误');
                            });
                    }
                }

                $scope.cancel = function () {
                    $modalInstance.close($scope.isAdded);
                }

                $scope.reset = function () {
                    $scope.role = {};
                }
            }
        ])
})