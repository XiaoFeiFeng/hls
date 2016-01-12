<?php 


header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

require('../../ice/common/lib/util/JSON.php');
      
$_REQUEST['action']();

function getUsers(){
    $mongo = new Mongo("mongodb://127.0.0.1:27017");    
    $database = $mongo->selectDB("logistic");    
    $collection = $database->selectCollection("logistics_category");  
    $cursor = $collection->find();
    $record = array();
    foreach ($cursor as $id => $value) {
        $record[] = $value;   
    }
    $json = new Services_JSON();                                                 
    echo $json->encode($record);
}



//获取互联易所有渠道列表  
function getTransportWayList(){           
    
    require('../../public/phpClass/Logistic.class.php');  
    $logistic = new Logistic();  
    $result = $logistic->getTransportWayList();    
    $json = new Services_JSON();                   
    echo $json->encode($result);
        
}


//查询物流运费
function getFee(){
    
    require('../../public/phpClass/Logistic.class.php');  
    
    $post = json_decode(file_get_contents("php://input"),true);
    
    $channels = array(); 
    
    if(is_array($post["channels"]) && count($post["channels"]))$channels = $post["channels"];
    
    if(isset($_GET["channels"]) && !empty($_GET["channels"]))$channels = explode(',',$_GET["channels"]);
    
    $logistic = new Logistic();
    $result = $logistic->calculateCharge($_GET["country"],$_GET["weight"],$channels);  
    
    if($result->success){
        if(!is_array($result->transportFee)){
            $result->transportFee = array($result->transportFee);
        }
    }else{
        $result = array(
            "success" => false,
            "error_msg" => $result->error->errorInfo
        );
    }
            
    $json = new Services_JSON(); 
    echo $json->encode($result);
    
}


//logistic_category列表  
function logistic_category(){
    $mongo = new Mongo("mongodb://127.0.0.1:27017");    
    $database = $mongo->selectDB("logistic");    
    $collection = $database->selectCollection("logistics_category");  
    $cursor = $collection->find();
    $record = array();
    foreach ($cursor as $id => $value) {
        $record[] = $value;   
    }
    $json = new Services_JSON();                                                 
    echo $json->encode($record);
}


//logistics_category_channels列表
function logistics_category_channels(){
    $mongo = new Mongo("mongodb://127.0.0.1:27017");    
    $database = $mongo->selectDB("logistic");    
    $collection = $database->selectCollection("logistics_category_channels");  
    
    $param["category"] = $_GET["category"];
    if(isset($_GET["status"]))$param["used"] = true;  //status参数区分 查询全部和只查询启用的渠道
    
    $cursor = $collection->find($param);
    $record = array();
    foreach ($cursor as $id => $value){
        $record[] = $value;   
    }                 
    $json = new Services_JSON();                                                 
    echo $json->encode($record);
}



/*****************************      
* 互联易运输方式 **********
**************************/

//新增logistic_category
function add_logistic_category(){      
    $mongo = new Mongo("mongodb://127.0.0.1:27017");    
    $database = $mongo->selectDB("logistic");    
    $collection = $database->selectCollection("logistics_category");   
    $collection->insert(json_decode(file_get_contents("php://input"),true)); 
    $mongo->close();  
}
//删除logistic_category
function remove_logistic_category(){      
    $mongo = new Mongo("mongodb://127.0.0.1:27017");       
    $collection = $mongo->logistic->logistics_category;      
    $collection->remove(array("_id"=>new MongoId($_GET["_id"])));
    $mongo->close();                   
}

//更新logistic_category
function edit_logistic_category(){    
    $mongo = new Mongo("mongodb://127.0.0.1:27017");       
    $collection = $mongo->logistic->logistics_category;    
    $where = array("_id" => new MongoId($_GET["_id"]));    
    $collection->update($where,json_decode(file_get_contents("php://input"),true));   
    $mongo->close();                   
}


                    
/*****************************      
* 互联易渠道管理 **********
**************************/

//新增logistics_category_channels   
function add_logistics_category_channels(){     
    $mongo = new Mongo("mongodb://127.0.0.1:27017");    
    $database = $mongo->selectDB("logistic");    
    $collection = $database->selectCollection("logistics_category_channels");   
    $collection->insert(json_decode(file_get_contents("php://input"),true)); 
    $mongo->close();                   
}

//删除logistics_category_channels
function remove_logistics_category_channels(){ 
    $mongo = new Mongo("mongodb://127.0.0.1:27017");       
    $collection = $mongo->logistic->logistics_category_channels;      
    $collection->remove(array("_id"=>new MongoId($_GET["_id"])));
    $mongo->close();                   
}

//更新logistics_category_channels
function edit_logistics_category_channels(){    
    $mongo = new Mongo("mongodb://127.0.0.1:27017");       
    $collection = $mongo->logistic->logistics_category_channels;    
    $where = array("_id" => new MongoId($_GET["_id"]));    
    $collection->update($where,json_decode(file_get_contents("php://input"),true));   
    $mongo->close();                   
}






   

?>
