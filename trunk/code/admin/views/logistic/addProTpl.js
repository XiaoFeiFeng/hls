'use strict'
define([], function () {
    angular.module('logistricCreateModule', [])
        .controller("logisticaddProTplCtrl", ['$scope', '$ui', '$validate', '$request', '$modalInstance', 'modalData', function (
            $scope, $ui, $validate, $request, $modalInstance, modalData) {
            $scope.logistic = {};
            if (!$validate.isEmpty(modalData) && !$validate.isEmpty(modalData._id)) {
                $scope.logistic = modalData;
                $scope.isEdit = true;
            }
            $scope.reset = function () {
                $scope.logistic = {};
            }

            $scope.cancel = function () {
                $modalInstance.close($scope.isAdded);
            }

            $scope.submitForm = function () {

                if ($scope.isEdit) {
                    var data = angular.copy($scope.logistic);
                    delete data._id;
                    delete data.$checked;

                    $request.post('api/logistic.action?action=edit_logistic&id=' + $scope.logistic._id.$id,
                        data,
                        function (response) {
                                $ui.notify('保存成功！', '提示',
                                    function () {
                                        $modalInstance.close(true);
                                    })
                        }, function (err) {
                            $ui.error('修改失败，' + err, '错误');
                        });
                } else {

                    $request.post('api/logistic.action?action=edit_logistic',
                        $scope.logistic,
                        function (response) {
                               $ui.confirm('添加成功，是否继续添加?', '确认',
                                    function () {
                                        $scope.reset()
                                        $scope.isAdded = true;
                                    },
                                    function () {
                                        $modalInstance.close(true);
                                    })
                        }, function (err) {
                            $ui.error('添加失败，' + err, '错误');
                        });
                }
            }
            /*$scope.submitForm = function () {
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
            }*/

        }])
})
