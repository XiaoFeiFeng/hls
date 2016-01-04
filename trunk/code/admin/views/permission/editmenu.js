'use strict'
define([], function () {
    angular.module('permissionEditMenuModule', [])
        .controller("permissionEditMenuCtrl", ['$scope', '$ui', '$validate', '$request', '$modalInstance', 'modalData',
            function ($scope, $ui, $validate, $request, $modalInstance, modalData) {

                if ($validate.isEmpty(modalData) || $validate.isEmpty(modalData.pcode)) {
                    $modalInstance.close();
                }
                $scope.pcode = modalData.pcode;
                $scope.menu = modalData;

                if (!$validate.isEmpty(modalData._id)) {
                    $scope.isEdit = true;
                }

                $scope.submitForm = function () {

                    var data = angular.copy($scope.menu);
                    data.pcode = $scope.pcode;
                    delete data._id;
                    delete data.pname;
                    delete data.children;
                    if ($scope.isEdit) {
                        $request.post('admin/data/?action=edit_menu&id=' + $scope.menu._id.$id,
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
                        $request.post('admin/data/?action=add_menu',
                            data,
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
                    $scope.menu = {};
                }
            }
        ])
})