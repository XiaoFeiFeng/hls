'use strict'
define([], function () {
    angular.module('logisticChannelTplModule', [])
        .controller("logisticChannelTplCtrl", ['$scope', '$ui', '$request', '$filter', 'ngTableParams', function ($scope, $ui, $request, $filter, ngTableParams) {
            $scope.getData = function () {

                $request.get('http://www.cpowersoft.com:8888/join/logistic/logistics_channel', function (response) {
                    $scope.listData = response.list;

                    $scope.tableParams = new ngTableParams({
                        page: 1,
                        count: 10,
                        sorting: {
                            channel_name: 'asc'
                        }
                    }, {
                        total: $scope.listData.length,
                        getData: function ($defer, params) {

                            var orderedData = params.sorting() ?
                                $filter('orderBy')($scope.listData, params.orderBy()) :
                                $scope.listData;

                            orderedData = params.filter ?
                                $filter('filter')(orderedData, params.filter()) :
                                orderedData;

                            $scope.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

                            params.total(orderedData.length);
                            $defer.resolve($scope.users);
                        }
                    });
                }, function () {
                })
            }

            $scope.delData = function (id) {

                $request.getWithData('http://www.cpowersoft.com:8888/logist_del/logistic/logistics_channel',
                    {id: id},
                    function (response) {
                        if (response == 'OK') {
                            $ui.notify('添加成功', '提示');
                        }
                        $scope.getData();
                    },
                    function () {
                    }
                );
            }

            $scope.getData();
        }])
})