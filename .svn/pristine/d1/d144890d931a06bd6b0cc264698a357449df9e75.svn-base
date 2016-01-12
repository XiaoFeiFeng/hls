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
    
    
    $result = $aliexpress->sendOrderMessage($access_token,$_GET["orderId"],$_GET["buyerLoginId"],$_GET["content"]);
    
    
    echo json_encode($result);
    
    
    
    
?>