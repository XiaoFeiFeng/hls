<?php
    
    
    require("../../../public/phpClass/common.php");
    
    
    $port = $_COOKIE['port'];         

    $mongo = new HMongodb("mongodb://192.168.1.99:".$port);
                                                                                                  
    $mongo->selectDb("erp");
                                    
    $mongo->remove("aliexpress_auditing_orders", array("orderId"=>$_GET["oid"]));
    
 
    
?>