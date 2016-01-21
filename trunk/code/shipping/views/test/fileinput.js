/**
 * Created by Administrator on 2015/12/10.
 */
'use strict'
define([], function () {
        var testFileInputModule = angular.module("testFileInputModule", []);

        testFileInputModule.controller('testFileInputCtrl', function ($scope, $ui) {
            $(document).ready(function () {
                $('#fileupload').on('fileuploaded', function (event, data, previewId, index) {
                    var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;
                    console.log('File uploaded triggered');
                });

                $('#fileupload').on('filebatchuploadsuccess', function (event, data, previewId, index) {
                    var form = data.form, files = data.files, extra = data.extra,
                        response = data.response, reader = data.reader;
                    console.log('File batch upload success');
                });
                $('#fileupload').on('filebatchuploadcomplete', function (event, files, extra) {
                    console.log('File batch upload complete');
                });


                $('#fileupload').on('fileerror', function (event, data) {
                    console.log(data.id);
                    console.log(data.index);
                    console.log(data.file);
                    console.log(data.reader);
                    console.log(data.files);
                });

                var data = {
                    name: "张三",
                    age: 35,
                    address: '深圳市南山区'
                }

                $("#fileupload").fileinput({
                    uploadUrl: 'http://93myb.com/admin/api/view/test.php', //文件上传地址
                    uploadAsync: true,
                    uploadExtraData: data,
                    maxFileCount: 5,
                    allowedFileExtensions: ['jpg', 'png', 'gif'],//允许文件后缀名
                    overwriteInitial: false,
                    maxFileSize: 1000,//单个文件最大值 (KB)
                    maxFilesNum: 10, //单次最多上传文件数
                    showCaption: false,//是否显示输入框
                    showPreview: true,//是否显示预览

                    browseClass: "btn btn-success",
                    browseLabel: "选择图片",
                    browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
                    removeClass: "btn btn-danger",
                    removeLabel: "删除",
                    removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
                    uploadClass: "btn btn-info",
                    uploadLabel: "上传",
                    uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",
                    //allowedFileTypes: ['image', 'video', 'flash'], //允许文件的类型
                    slugCallback: function (filename) {
                        return filename.replace('(', '_').replace(']', '_');
                    }
                });
            });
        });
    }
)