/**
 * Created by Administrator on 2016/1/28.
 */

'use strict'
define([],function(){
    angular.module('addressCompileModule',[])
        .controller('addressCompileCtrl',['$scope','$ui','$uibModalInstance','modalData',
            function($scope,$ui,$uibModalInstance,modalData){
            $scope.result = modalData;
            //¹Ø±Õ´°¿Ú
            $scope.cancel = function () {
                $uibModalInstance.close();
            }
            //±£´æ
            $scope.save = function(){
                console.log($scope.result);
            }

        }])
})
