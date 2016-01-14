'use strict'
define([], function () {
    angular.module('channelIndexModule', [])
        .controller("channelIndexCtrl", ['$scope', '$ui', '$request', '$validate', function ($scope, $ui, $request, $validate) {
            $scope.categorys = [];
            $scope.channels = [];
            $scope.currentCategory = "";
            $scope.getCategory = function () {
                $request.get(
                    'api/?action=logistic_category',
                    function (response) {
                        $scope.categorys = response;
                    }, function (err) {
                        $ui.error('错误', err);
                    }
                );
            }

            $scope.state = function (used) {
                return used ? "启用" : "未启用";
            }
            $scope.stateOper = function (used) {
                return used ? "禁用" : "启用";
            }

            $scope.getChannels = function (type) {
                $request.get(
                    'api/?action=logistics_category_channels&category=' + type.code,
                    function (response) {
                        $scope.channels = response;
                        $scope.currentCategory = type;
                    }, function (err) {
                        $ui.error('错误', err);
                    }
                );
            }

            $scope.addChannel = function () {
                if ($validate.isEmpty($scope.currentCategory)) {
                    return;
                }
                var data = {
                    'operator': 'add',
                    'category': $scope.currentCategory
                }
                $ui.openWindow('views/channel/addorEdit.html', 'channeladdOrEditCtrl', data, function (data) {
                    $scope.getChannels($scope.currentCategory);
                }, function (data) {
                });
            }

            $scope.modifyChannel = function (channel) {
                var data = {
                    'operator': 'edit',
                    'category': $scope.currentCategory,
                    'channel': channel
                }
                $ui.openWindow('views/channel/addorEdit.html', 'channeladdOrEditCtrl', data, function (data) {
                    $scope.getChannels($scope.currentCategory);
                }, function (data) {

                });
            }

            $scope.modifyState = function (channel) {
                var data = {
                    name: channel.name,
                    code: channel.code,
                    category: channel.category,
                    used: !channel.used
                }
                $request.post('api/?action=edit_logistics_category_channels&_id=' + channel._id.$id,
                    data,
                    function (response) {
                        $scope.getChannels($scope.currentCategory);
                    }, function (err) {

                    });
            }

            $scope.delChannel = function (id) {
                $ui.confirm('确认删除?', '确认',
                    function () {
                        $request.get('api/?action=remove_logistics_category_channels&_id=' + id,
                            function (response) {
                                $ui.notify('删除成功', '提示');
                                $scope.getChannels($scope.currentCategory);
                            }, function (err) {

                            });
                    });
            }
            $scope.getCategory();
        }])
})