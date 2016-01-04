'use strict'
define([], function () {
    angular.module('permissionUserModule', [])
        .controller("permissionUserCtrl", ['$scope', '$ui', '$validate', '$request',
            function ($scope, $ui, $validate, $request) {

                $scope.currentPage = 1;

                $scope.pageChange = function () {
                    $scope.changedPage = $scope.currentPage;
                }

                $scope.add = function () {
                    $ui.openWindow('views/permission/edituser.html', 'permissionEditUserCtrl', null, function () {
                        $scope.initGridData();
                    });
                }
                $scope.edit = function (data) {
                    $ui.openWindow('views/permission/edituser.html', 'permissionEditUserCtrl', data, function (result) {
                        if (result) $scope.initGridData();
                    });
                }
                $scope.batchDel = function () {
                    var ids = [];
                    angular.forEach($scope.gridOptions.colsChk.data, function (item) {
                        ids.push(item._id.$id);
                    })

                    if (ids.length > 0) {
                        $ui.confirm("确认删除？", "确认", function () {
                            $request.post('admin/data/?action=remove_users', ids, function (response) {
                                if (response.success) {
                                    $scope.initGridData();
                                } else if (angular.isUndefined(response.success)) {
                                    $ui.error(response);
                                } else {
                                    $ui.error(response.error);
                                }
                            });
                        });
                    }

                }

                $scope.del = function (id) {
                    $request.get('admin/data/?action=remove_user&id=' + id, function (response) {
                        if (response.success) {
                            $scope.initGridData();
                        } else if (angular.isUndefined(response.success)) {
                            $ui.error(response);
                        } else {
                            $ui.error(response.error);
                        }
                    });
                }

                $scope.formatterGender = function (value) {
                    if (value == '0') {
                        return '男';
                    }
                    else {
                        return '女';
                    }
                }

                $scope.gridOptions = {
                    data: [],
                    cols: [
                        {FieldName: 'name', DisplayName: '姓名',},
                        {FieldName: 'password', DisplayName: '密码',},
                        {FieldName: 'email', DisplayName: '邮箱',},
                        {FieldName: 'telephone', DisplayName: '电话',}
                    ],
                    colsOpr: {
                        headName: '操作',
                        headClass: '',
                        init: {
                            showView: false,
                            viewFn: function (data) {
                                alert('view');
                            },
                            showEdit: true,
                            editFn: function (data) {
                                $scope.edit(data);
                            },
                            showDelete: true,
                            delFn: function (data) {
                                $ui.confirm("确认删除？", "确认", function () {
                                    $scope.del(data._id.$id);
                                });
                            }
                        },
                        colInfo: [
                            {
                                title: '设置角色',
                                iconClass: 'fa fa-user',
                                clickFn: function (data) {
                                    alert('self define');
                                },
                            },
                        ],
                    },
                    colsChk: {//if not need checkbox,undefined this
                        //rowCheckname: 'checked',//if undefined,use default name
                        checkAllChange: function () {
                        },
                        rowCheckChange: function (data) {
                        },
                        keyName: '_id',//if not get selected data.undefined
                        data: [],//if not get selected data.undefined
                    },
                    rowOpr: {
                        rowSelected: function (data) {
                            //alert("row selected");
                        },
                    },
                    colsHidden: [],
                }

                $scope.getSelectData = function () {
                    alert(angular.toJson($scope.gridOptions.colsChk.data));
                }

                $scope.setSelectData = function () {
                    var index = 1;
                    angular.forEach($scope.gridOptions.data, function (record) {
                        if (index % 2 == 0) {
                            $scope.gridOptions.colsChk.data.push(record);
                        }
                        index++;
                    });
                }

                $scope.clearSelectData = function () {
                    $scope.gridOptions.colsChk.data = [];
                }

                $scope.initGridData = function () {
                    $request.get('admin/data/?action=get_users', function (response) {
                        if (response.success) {
                            $scope.gridOptions.data = response.data;
                            $scope.totalItems = response.data.length;
                        } else if (angular.isUndefined(response.success)) {
                            $ui.error(response);
                        } else {
                            $ui.error(response.error);
                        }
                    });

                }

                $scope.initGridData();
            }
        ])
})