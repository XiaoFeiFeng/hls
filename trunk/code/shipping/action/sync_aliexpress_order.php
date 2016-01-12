<?php               
 
    require('../../../public/phpClass/common.php');        
    require('include/Aliexpress.class.php');        
    
    //echo getUid();
    
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
    
    $record = $mongo->findOne("aliexpress_accounts", array("_id"=>new MongoId($_GET["account"])), array());
    
    
    $aliexpress = new aliexpress();
    
    
    $access_token = $aliexpress->getAccessToken($mongo,$record); 
     
   
    $orders = $aliexpress->loadOrder($access_token);
    
          
    /*echo "<pre>";  
    
    var_dump($orders);exit;*/
   
    $totalItem = 0;    
   
    $totalPage = ceil($orders["totalItem"] / 50);
    
    for($page=1;$page<=$totalPage ;$page++){
        
        //echo 'page-'.$page.'<br>';    
          
        $result = array();
        
        if($page > 1 ){   
            $orders = $aliexpress->loadOrder($access_token,$page);   
        }           
        
        if(isset($orders["orderList"]) &&  !empty($orders["orderList"]) && is_array($orders["orderList"])){          
                   
            foreach($orders["orderList"] as $ord){             
                $record = $mongo->findOne("aliexpress_auditing_orders", array("orderId"=>(string)$ord["orderId"]), array());
                $record_is_handling = $mongo->findOne("aliexpress_auditing_orders_handling", array("orderId"=>(string)$ord["orderId"]), array());
                     
                if(empty($record) && empty($record_is_handling)){
                    $orderDetail = $aliexpress->orderDetail($access_token,$ord["orderId"]);
                      
                    //echo "<pre>";        
                    //var_dump($orderDetail);
                    
                    $productList = array();
                    
                    $memo = '';
                    
                    foreach($ord["productList"] as $product){
                        
                        
                        if(isset($product["memo"]) && !empty($product["memo"])){
                            
                            $memo .= "【 ".$product["skuCode"]." 】   ". $product["memo"];   
                        }    
                        $productList[] = array(                               
                           "logisticsServiceName"=> $product["logisticsServiceName"],
                           "logisticsAmount"=> $product["logisticsAmount"],
                           "childId"=> $product["childId"],
                           "sonOrderStatus"=> $product["sonOrderStatus"],
                           "productSnapUrl"=> $product["productSnapUrl"],
                           "moneyBack3x"=> $product["moneyBack3x"],
                           "productUnit"=> $product["productUnit"],
                           "skuCode"=> $product["skuCode"],
                           "memo"=> isset($product["memo"]) ? $product["memo"] : "",
                           "productId"=> $product["productId"],
                           "productCount"=> $product["productCount"],
                           "productUnitPrice"=> $product["productUnitPrice"]["amount"],
                           "totalProductAmount"=> $product["totalProductAmount"],
                           "productImgUrl"=> $product["productImgUrl"],
                           "logisticsType"=> $product["logisticsType"],
                           "productName"=> $product["productName"],
                           "productUnitPriceCur"=> $product["productUnitPrice"]["currencyCode"]       
                        );        
                                 
                    }
                    
                    
                    $module = array(              
                       "orderId"=>  (string)$ord["orderId"],          
                       "gmtCreate"=> splitData($ord["gmtCreate"]),        
                       "productList"=> $productList,  
                       "orderStatus"=> $ord["orderStatus"],                         
                       "countryCode"=> strtolower($orderDetail["receiptAddress"]["country"]),  
                       "receiptAddress" => $orderDetail["receiptAddress"],
                       "amount" => $ord["payAmount"]["amount"],  
                       "currencyCode" => $ord["payAmount"]["currencyCode"],  
                       "paymentType" => $ord["paymentType"],  
                       "hasRequestLoan" => $ord["hasRequestLoan"],   //是否已请求放款
                       "issueStatus" => $ord["issueStatus"],     //纠纷状态    
                       "fundStatus" => $ord["fundStatus"],     //资金状态    
                       "frozenStatus" => $ord["frozenStatus"],     //冻结状态    
                       "escrowFeeRate" => $ord["escrowFeeRate"],     //手续费率    
                       "buyerLoginId" => $ord["buyerLoginId"],             //买家登录ID        
                       "buyerSignerFullname" => $ord["buyerSignerFullname"],     //买家全名    
                       "detailAddress" => $orderDetail["receiptAddress"]["detailAddress"],     //买家全名    
                       "orderMsgList" => $orderDetail["orderMsgList"],     //留言信息    
                       "buyerInfo" => $orderDetail["buyerInfo"],
                       "isPhone" => $orderDetail["isPhone"],            
                       "gmtModified" => $orderDetail["gmtModified"],
                       "sellerOperatorLoginId" => $orderDetail["sellerOperatorLoginId"],
                       "childOrderExtInfoList" => $orderDetail["childOrderExtInfoList"],
                       "account" => new MongoId($_GET["account"]),
                       "memo" => $memo,
                       "deliveryTime" => time()+ floor($ord["timeoutLeftTime"]/1000)
                    );
                    
                    $mongo->insert("aliexpress_auditing_orders",$module);     
                    $result[] = $module;    
                }                              
            }                              
        }    
        $totalItem += count($result);    
    }                    
    
                               
    echo json_encode(array("success"=>true,"totalItem"=>$totalItem));
    
      
    function splitData($date){ 
        $year = substr($date,0,4);   
        $month = substr($date,4,2);  
        $day = substr($date,6,2);  
        $hour = substr($date,8,2); 
        $min = substr($date,10,2);  
        $sen = substr($date,12,2);  
        return $year.'-'.$month.'-'.$day.' '.$hour.':'.$min.':'.$sen;     
    }
       
?>