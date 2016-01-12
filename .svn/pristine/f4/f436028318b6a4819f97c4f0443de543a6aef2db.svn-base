<?php
   /**
    * 标记速卖通审核订单异常
    * 
    */
    
      
    require('../../../public/phpClass/common.php');       
    
    
    
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
    
    
    $record = $mongo->findOne('aliexpress_auditing_orders',array('orderId'=>$_GET["oid"]));
    
    if($_GET["type"] == "mark") $record["mark_exceptions"] = true;
    else $record["mark_exceptions"] = false;
                                                                              

    $mongo->update("aliexpress_auditing_orders", array('orderId'=>$_GET["oid"]),$record,array("upsert"=>1));
?>