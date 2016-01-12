 <?php

define('ALIEXPRESS_APPKEY','9223302');             //aliexpress appkey
define('ALIEXPRESS_APPSECRET','IyW9Jy8MermW');     //aliexpress_appsecret


class aliexpress{
    
    
    /**
     * 构造函数
     *
     * @param object $query
     */
    function __construct() {
        
    }
    
    
    public function getAccessToken($db,$record){

        //return $record;
        //refresh_expires_in 授权时间 + 39528000
        
        $expires_30_time = time() - 2592000; //30天 = 2592000秒
        
        $result = array();
        
        if( time() > $record["refresh_expires_in"]){   //第一种情况 已经过期
            //重新授权    
            $result["error"] = "refresh expires!";
        }else{
           
            if(time() > $record["access_expires_in"]){ //accessToken 过期    
                $access_token = $this->refreshChangeAccess(array(
                    "appkey" => ALIEXPRESS_APPKEY,
                    "appSecret" => ALIEXPRESS_APPSECRET,
                    "refresh_token" => $record["refresh_token"],   
                    "accountObjectId" => $record["_id"], 
                    "db" => $db,
                    "record" => $record
                ));
                $result["access_token"] = $access_token;
            }else{
                $result["access_token"] = $record["access_token"];
            }                
            
            //判断是否30天内过期    
            if( $expires_30_time > $record["refresh_expires_in"]){
                //距离过期30天内
                
            }else{
                
            }
        }
        return $result["access_token"];
    }
    
    /**
    * 加载订单
    * 
    * @param mixed $access_token
    * @param mixed $page
    * @return mixed
    */
    function loadOrder($access_token,$page=1){      
        $result = $this -> RequestAli('http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findOrderListQuery/'.ALIEXPRESS_APPKEY.'?page='.$page.'&pageSize=50&orderStatus=WAIT_SELLER_SEND_GOODS&access_token='.$access_token."&_aop_signature=".$this->_aop_signature('param2/1/aliexpress.open/api.findOrderListQuery/'.ALIEXPRESS_APPKEY,array(
            'page' => $page,
            'pageSize' => '50',             
            'orderStatus' => 'WAIT_SELLER_SEND_GOODS',
            'access_token' => $access_token
        )));
        return $result;   
    }
    
    /**
    * 获取订单详情
    * 
    * @param mixed $access_token
    * @param mixed $orderId
    * @return mixed
    */
    function orderDetail($access_token,$orderId){
        //http://gw.api.alibaba.com:80/openapi/param2/1/aliexpress.open/api.findOrderById/9223302?orderId=71436203375571&fieldList=receiptAddress&access_token=51779300-3e2c-4ebd-bc12-95cd5e434259&
        $result = $this -> RequestAli('http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.findOrderById/'.ALIEXPRESS_APPKEY.'?orderId='.$orderId.'&access_token='.$access_token."&_aop_signature=".$this->_aop_signature('param2/1/aliexpress.open/api.findOrderById/'.ALIEXPRESS_APPKEY,array(
            'orderId' => $orderId,                  
            'access_token' => $access_token
        )));
        return $result;   
    }
    
    /***
    * 发送站内信  api.addMsg
    * 
    * @param mixed $access_token
    * @param mixed $channelId     orderId 71456417318798 nl1012936246
    * @param mixed $buyerId
    * @param mixed $content
    * @param mixed $msgSources
    */
    function sendOrderMessage($access_token,$channelId,$buyerId,$content,$msgSources="order_msg"){
        //http://gw.api.alibaba.com:80/openapi/param2/1/aliexpress.open/api.addMsg/9223302?channelId=71523309264419&buyerId=nl1110290493dgkm&content=hello%20thanks!&msgSources=order_msg&access_token=0bb5f750-592e-40de-ab5f-be90ec0d6b68&_aop_signature=1B07C9FA84ABF8871E8B2867EE2A47ECFC8A1862        
        $result = $this -> RequestAli('http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/api.addMsg/'.ALIEXPRESS_APPKEY.'?channelId='.$channelId.'&buyerId='.$buyerId.'&content='.$content.'&msgSources='.$msgSources.'&access_token='.$access_token."&_aop_signature=".$this->_aop_signature('param2/1/aliexpress.open/api.findOrderById/'.ALIEXPRESS_APPKEY,array(
            'channelId' => $channelId,                  
            'buyerId' => $buyerId,                  
            'content' => $content,                  
            'msgSources' => $msgSources,                  
            'access_token' => $access_token
        )));
        return $result;   
    }
    
    
    
    
    /**
     * 
     * @param string $url
     * GET方式
     *
     */
    function RequestAli($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $re=curl_exec($ch);
        curl_close($ch);
        return json_decode($re,true);
    }
    /**
     * 
     * @param string $url
     * GET方式
     *
     */
    function PostAli($apiName,$curlPost)
    {                                            
        //计算签名             
        $_aop_signature = $this->_aop_signature(
            'param2/1/aliexpress.open/'.$apiName.'/'.ALIEXPRESS_APPKEY,
            $curlPost
        );
        
        $curlPost["_aop_signature"] = $_aop_signature;
     
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//接收结果为字符串
        curl_setopt($ch, CURLOPT_URL,'http://gw.api.alibaba.com/openapi/param2/1/aliexpress.open/'.$apiName.'/'.ALIEXPRESS_APPKEY);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlPost));
        $re=curl_exec($ch);
        curl_close($ch);
        return json_decode($re,true);
    }
    
    
    /**
    * 签名
    * 
    * @param mixed $apiInfo
    * @param mixed $code_arr
    * @return string
    */
    function _aop_signature($apiInfo,$code_arr){
        $appKey = ALIEXPRESS_APPKEY;
        $appSecret = ALIEXPRESS_APPSECRET;
        $sign_str = "";
        ksort($code_arr);
        foreach ($code_arr as $key=>$val)
            $sign_str .= $key . $val;
        $sign_str = $apiInfo . $sign_str;
        $code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, $appSecret, true)));    
        return $code_sign;
        
    }
        
    /**
     * refresh_token换取access_token
     *
     * @param array $info  array('appkey','appSecret','refresh_token','id')
     * @return string  (access_token)
     */
    private function refreshChangeAccess($info){
       
        $curlPost = array(
                'grant_type' => 'refresh_token',
                'client_id' => $info['appkey'],
                'client_secret' => $info['appSecret'],
                'refresh_token' => $info['refresh_token']
                );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//接收结果为字符串
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //https请求必须加上此项
        curl_setopt($ch, CURLOPT_URL,'https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/getToken/'.$info['appkey']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlPost));
        $re=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($re,true);
        
        //更新myb ali_accounts access_token 与 access_expires_in
                        
        $info["record"]["access_token"] = $result["access_token"];
        $info["record"]["access_expires_in"] = time() + 3600;
        $info['db']->update("aliexpress_accounts", array("_id"=>$info["accountObjectId"]),$info["record"],array("upsert"=>1));
        return $result["access_token"];
    }    
    
    
    
    
    private function postponeToken($info){
       
        $curlPost = array(
                'client_id' => 'refresh_token',
                'client_secret' => $info['appkey'],
                'refresh_token' => $info['appSecret'],
                'access_token' => $info['refresh_token']
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//接收结果为字符串
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //https请求必须加上此项
        curl_setopt($ch, CURLOPT_URL,'https://gw.api.alibaba.com/openapi/param2/1/system.oauth2/postponeToken/'.$info['appkey']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($curlPost));
        $re=curl_exec($ch);
        curl_close($ch);
        $result=json_decode($re,true);
        
        return $result;    
        
    } 

   

}


    
?>