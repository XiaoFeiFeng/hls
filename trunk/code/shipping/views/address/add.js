/**
 * Created by Administrator on 2016/1/27.
 */

'use strict'
define([],function(){
    angular.module('addressAddModule',[])
        .controller('addressAddCtrl',['$scope','$ui','$uibModalInstance',function($scope,$ui,$uibModalInstance){

            $scope.cancel = function () {
                $uibModalInstance.close();
            }



        }])
})
