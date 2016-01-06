'use strict'
define([], function () {
    angular.module('logisticaddChannelTplModule', [])
        .controller("logisticaddChannelTplCtrl", ['$scope', '$ui', '$request', function ($scope, $ui, $request) {
            $scope.flag = {};
            $request.get('http://www.cpowersoft.com:8888/logist_find/logistic/logistic',
                function (response) {
                    $scope.flag.pros = response.list;
                }, function (err) {

                })

            $scope.submitFlag = true;

            $scope.reset = function () {
                $scope.submitFlag = true;
            }

            $scope.$watch('pro', function (newValue) {
                if (newValue != undefined) {
                    if (newValue.channel_name && newValue.channel_code && newValue.channel_pro)
                        $scope.submitFlag = false;
                }
            }, true);

            $scope.submitForm = function () {
                $.ajax({
                    type: 'POST',
                    url: 'http://www.cpowersoft.com:8888/logist/logistic/logistics_channel',
                    data: {
                        "channel_name": $scope.pro.channel_name,
                        "channel_code": $scope.pro.channel_code,
                        "channel_logId": $scope.pro.channel_pro._id
                    },
                    dataType: 'html',
                    headers: {
                        "Content-Type": "application/x-www-form-urlencoded"
                    },
                    success: function (data) {
                        if (data == 'OK') {
                            $ui.notify('删除成功', '提示');
                            $scope.pro = {};
                        }
                    }
                })
            }
        }])
})