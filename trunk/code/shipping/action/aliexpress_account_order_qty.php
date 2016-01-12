<?php
   /**
    * 获取所有账号订单数量
    * 
    */
                   
      
    require('../../../public/phpClass/common.php');             
    require('include/Aliexpress.class.php');          
        
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
                  
    $aliexpress = new aliexpress();
    
    $accounts = explode(",",$_GET["accounts"]);
                                    
    $result = array();                                
                                    
    foreach($accounts as $key => $oid){
        
        $totalItem = 0;
                                 
        $record = $mongo->findOne("aliexpress_accounts", array("_id"=>new MongoId($oid)), array());
    
        $access_token = $aliexpress->getAccessToken($mongo,$record); 
                                    
        $orders = $aliexpress->loadOrder($access_token);   
        
        if(isset($orders["totalItem"]))$totalItem = $orders["totalItem"];
        
        $result[$key] = $totalItem;
             
    }
    
    echo json_encode($result);
                      
                             
?>