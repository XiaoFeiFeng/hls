/**
 * Created by Administrator on 2016/1/28.
 */

'use strict'
define(['angular-city'],function(){
    angular.module('addressCompileModule',[])
        .controller('addressCompileCtrl',['$scope','$ui','$uibModalInstance','modalData',
            function($scope,$ui,$uibModalInstance,modalData){
            $scope.result = modalData;

            $scope.item = {
                city: [$scope.result.province, $scope.result.city, $scope.result.district]
                // city: '350524'
            };
            //关闭窗口
            $scope.cancel = function () {
                $uibModalInstance.close();
            }
            //保存
            $scope.save = function(){
                $scope.result.province  = $scope.item.city.cn[0];
                $scope.result.city      = $scope.item.city.cn[1];
                $scope.result.district  = $scope.item.city.cn[2];

                console.log($scope.result);
            }

        }])
})
