<?php
    
    
    
function geturl(){
    $redirect_uri = 'http://www.93myb.com/supplier/data/ALI_connect_callback.php';
    $code_arr = array(
        'client_id' => '6979070',
        'redirect_uri' => $redirect_uri,
        'site' => 'aliexpress'
    );
    ksort($code_arr);
           $sign_str ='';
    foreach ($code_arr as $key=>$val){
        $sign_str .= $key . $val;
    }
    $code_sign = strtoupper(bin2hex(hash_hmac("sha1", $sign_str, 'Ky97rOPnrS', true)));//$code_sign -- 签名
    $get_code_url = "http://gw.api.alibaba.com/auth/authorize.htm?client_id=6979070&redirect_uri={$redirect_uri}&site=aliexpress&_aop_signature={$code_sign}";
    echo $get_code_url;
}

 
geturl();    
    
?>