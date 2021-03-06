/**
 * Created by Administrator on 2016/1/19.
 */

'use strict'
define(['angular-city'],function(){
    angular.module('addressIndexModule',[])
        .controller('addressIndexCtrl',function($scope,$ui){
            $scope.isAllChecked = false;
            $scope.isCheck1 = false;
            $scope.isCheck2 = false;
            $scope.isCheck3 = false;
            $scope.dizhi = [
                {name:'小红',tel:'18218846438',province:'广东',city:'深圳市',district:'南山区',
                 detailed:'朗山二号路中3号互联易电商园三楼互联速',is_default:true,check:false
                },
                {name:'小青',tel:'13800138000',province:'广东',city:'深圳市',district:'福田区',
                 detailed:'八卦四路22号华盛晟达大夏四楼408',is_default:false,check:false
                },
                {name:'小黄',tel:'13799799577',province:'广东',city:'深圳市',district:'宝安区',
                 detailed:'宝民二路108号西乡街道办文化体育中心1楼',is_default:false,check:false
                },
                {name:'小绿',tel:'15860391521',province:'广东',city:'深圳市',district:'罗湖区',
                 detailed:'罗沙公路经二路1号（罗湖体育局对面）',is_default:false,check:false
                }
            ]

            $scope.isAllChange = function(){
                for(var i=0;i<$scope.dizhi.length;i++){
                    $scope.dizhi[i].check = $scope.isAllChecked;
                }
            }

            $scope.isOneChange = function(){

                var check = true;
                for(var i=0;i<$scope.dizhi.length;i++){
                    if(!$scope.dizhi[i].check){
                        check = false;
                    }
                }
                $scope.isAllChecked = check;
            }

            $("[name=selected]").click(function(){
                $(".address-info div").remove();
                var aa = $("[name=selected]");
                for(var i=0;i<aa.length;i++){
                    if(aa[i].checked){
                        var index = 1;
                        $('.address-info:eq(' + i + ')').append("<div class='selected-trigon'> " +
                                                                        "<div class='right-angle'></div> " +
                                                                        "<div class='default'>默认</div> " +
                                                                    "</div>");
                    }
                }
            })
            $scope.checked = function(index){
                for(var i=0;i<$scope.dizhi.length;i++){
                    var a = index;
                    $scope.dizhi[i].is_default = false;
                }
                $scope.dizhi[index].is_default = true;
            }
            $scope.deleteAddress = function(){
                var whether = false;
                for(var i=0;i<$scope.dizhi.length;i++){
                    if($scope.dizhi[i].check){
                        whether = true;;
                    };
                };
                if(whether){
                    $ui.confirm('确认删除？', '确认', function () {
                        for(var i=0;i<$scope.dizhi.length;i++){
                            if($scope.dizhi[i].check){
                                alert($scope.dizhi[i].name);
                            };

                        };

                    });

                }else{
                     $ui.notify('至少勾选一条地址','提示',function(){
                         return;
                     });
                }

            };
            //添加地址
            $scope.address = function(){
                $ui.openWindow('views/address/add.html', 'addressAddCtrl', null, function (result) {

                });
            };
            //修改地址

            $scope.compile = function(data){
                $ui.openWindow('views/address/compile.html', 'addressCompileCtrl', data, function (result) {

                });
            }



        })
})
