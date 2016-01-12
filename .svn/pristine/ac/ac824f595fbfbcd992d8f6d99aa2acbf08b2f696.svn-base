<?php
   /**
    * 开始处理速卖通审核订单
    * 
    */
    
    
    
    require('../../../public/phpClass/common.php');       
    
    
    
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
    
    
    $record = $mongo->findOne('aliexpress_auditing_orders',array('orderId'=>$_GET["oid"]));
                                       
    $mongo->remove("aliexpress_auditing_orders", array("orderId"=>$_GET["oid"]));
                  
    $mongo->insert("aliexpress_auditing_orders_handling", array("orderId"=>$_GET["oid"])); 
    
    $mongo->insert("aliexpress_confirm_shipping_orders", $record);
    
      
    var_dump($_GET["oid"]);
    
    
?>