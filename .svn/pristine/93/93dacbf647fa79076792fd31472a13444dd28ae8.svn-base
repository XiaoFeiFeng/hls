<?php
   /**
    * 开始处理速卖通所有审核订单
    * 
    */
     
    require('../../../public/phpClass/common.php');       
                    
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
                                
    $record = $mongo->find('aliexpress_auditing_orders',array());
    
                 
    foreach($record as $order){
                                                    
        $mongo->remove("aliexpress_auditing_orders", array("orderId"=>$order["orderId"]));
                      
        $mongo->insert("aliexpress_auditing_orders_handling", array("orderId"=>$order["orderId"])); 
        
        $mongo->insert("aliexpress_confirm_shipping_orders", $order);
         
    }
    
    echo count($record);
    
?>