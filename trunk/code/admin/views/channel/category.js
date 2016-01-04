'use strict'
define([], function () {
    angular.module('channelCategoryModule', [])
        .controller("channelCategoryCtrl", ['$scope', '$ui', '$request', '$validate', function ($scope, $ui, $request, $validate) {
            $scope.categorys = [];
            $scope.category = {};
            $scope.isEdit = false;

            $scope.getCategory = function () {
                $request.get(
                    'shipping/data/?action=logistic_category',
                    function (response) {
                        $scope.categorys = response;
                        $scope.reset();
                    }, function (err) {
                        $ui.error('错误', err);
                    }
                );
            }


            $scope.addCategory = function () {
                if ($validate.isEmpty($scope.category)) {
                    return;
                }
                $request.post('shipping/data/?action=add_logistic_category',
                    $scope.category,
                    function (response) {
                        $ui.notify('添加成功', '提示', function () {
                            $scope.getCategory();
                        });
                    }, function (err) {
                        $ui.error('添加失败，' + err, '错误');
                    });
            }

            $scope.saveCategory = function () {
                if ($validate.isEmpty($scope.category)) {
                    return;
                }
                var data = {
                    name: $scope.category.name,
                    code: $scope.category.code
                }
                $request.post('shipping/data/?action=edit_logistic_category&_id=' + $scope.category._id.$id,
                    data,
                    function (response) {
                        $ui.notify('保存成功', '提示', function () {
                            $scope.getCategory();
                        });
                    }, function (err) {
                        $ui.error('保存失败，' + err, '错误');
                    }
                );
            }
            $scope.reset = function () {
                $scope.category = {};
                $scope.isEdit = false;
            }

            $scope.modifyCategory = function (channel) {
                $scope.category = angular.copy(channel);
                $scope.isEdit = true;
            }

            $scope.delCategory = function (id) {
                $ui.confirm("确认删除？", '确认', function () {
                    $request.get('shipping/data/?action=remove_logistic_category&_id=' + id,
                        function (response) {
                            $ui.notify('删除成功', '提示');
                            $scope.getCategory();
                        }, function (err) {

                        });
                }, function () {
                })
            }

            $scope.getCategory();


        }])
})