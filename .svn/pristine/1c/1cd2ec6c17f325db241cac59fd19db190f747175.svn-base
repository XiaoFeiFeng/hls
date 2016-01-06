'use strict'
define([], function () {
    angular.module('channellistModule', [])
        .controller("channellistCtrl", ['$scope', '$ui', '$validate', '$request',
            function ($scope, $ui, $validate, $request) {

                $request.get(
                    'shipping/data/?action=action=getTransportWayList',
                    function (response) {
                        $scope.channels = response;
                    }, function (err) {
                    }
                );
            }
        ])
})