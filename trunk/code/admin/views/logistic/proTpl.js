'use strict'
define([], function () {
    angular.module('logistricproTplModel', [])
        .controller("logistricProTplCtrl", ['$scope', '$ui', '$request', '$filter', 'ngTableParams', function ($scope, $ui, $request, $filter, ngTableParams) {
            $scope.getData = function () {

                $request.get(
                    'http://www.cpowersoft.com:8888/logist_find/logistic/logistic',
                    function (response) {
                        $scope.listData = response.list;
                        $scope.tableParams = new ngTableParams({
                            page: 1,
                            count: 10,
                            sorting: {
                                name: 'asc'
                            }
                        }, {
                            total: $scope.listData.length,
                            getData: function ($defer, params) {

                                var orderedData = params.sorting() ?
                                    $filter('orderBy')(response.list, params.orderBy()) :
                                    $scope.listData;

                                orderedData = params.filter ?
                                    $filter('filter')(orderedData, params.filter()) :
                                    orderedData;

                                $scope.users = orderedData.slice((params.page() - 1) * params.count(), params.page() * params.count());

                                params.total(orderedData.length);
                                $defer.resolve($scope.users);
                            }
                        });
                    }, function (err) {

                    }
                );
            }

            $scope.delData = function (id) {

                $request.getWithData('http://www.cpowersoft.com:8888/logist_del/logistic/logistic',
                    {id: id},
                    function (response) {
                        if (response == 'OK') {
                            $ui.notify('删除成功', '提示');
                        }
                        $scope.getData();
                    }, function (err) {

                    });
            }

            $scope.getData();
        }])
})