<?php
// +--------------------------------------------------------------+
// | 这个文件是 EPR 项目的一部分                                   |
// +--------------------------------------------------------------+
// | Copyright (c) 2012 - 2015  
// |                                                              |
// | 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件  |
// +--------------------------------------------------------------+


/**
 * 常用函数
 *
 * @copyright Copyright (c) 2010 - 2015
 * @package Util
 * @version v0.1
 */

/**
 * 调试使用情况
 */
function debug_using()
{
	echo '执行时间：'.(array_sum(explode(' ', microtime()))-$GLOBALS['_start_time_']).' 秒.<br>';
	if (function_exists('memory_get_usage')) {
		echo '内存使用：'.number_format(memory_get_usage()).' 字节.<br>';
	}	
}
/**
 * 将提交的数据进行html格式编码
 * @param array $array 处理的数组
 * @param array $lists 要处理的数组中key的数组
 * @return array
 */
function specConvert (&$array, $lists) {
	if (!defined('CFG_CHARSET')) {
		define('CFG_CHARSET','utf-8');
	}
	foreach ($lists as $value) {
		$array[$value] = htmlspecialchars($array[$value],ENT_COMPAT,CFG_CHARSET);
		$array[$value] = str_replace("\n","<br>",$array[$value]);
		$array[$value] = trim($array[$value]);
	}
	return $array;
}
/**
 * 将specConvert编码后的数据解码
 * @param array $array 处理的数组
 * @param array $lists 要处理的数组中key的数组
 * @return array
 */
function specDeConvert (&$array, $lists) {
	if (!defined('CFG_CHARSET')) {
		define('CFG_CHARSET','utf-8');
	}
	foreach ($lists as $value) {
		$array[$value] = html_entity_decode($array[$value],ENT_COMPAT,CFG_CHARSET);
		$array[$value] = str_replace("<br>","\n",$array[$value]);
	}
	return $array;
}
/**
 * 双字节字符截取
 *
 * @param string $content
 * @param int $length
 * @return string
 */
function substrs($content, $length){
	if (!defined('CFG_CHARSET')) {
		define('CFG_CHARSET','utf-8');
	}
	if($length && strlen($content)>$length){
		if(CFG_CHARSET!='utf-8'){
			$retstr='';
			for($i = 0; $i < $length - 2; $i++) {
				$retstr .= ord($content[$i]) > 127 ? $content[$i].$content[++$i] : $content[$i];
			}
			return $retstr.' ..';
		}else{
			return utf8_trim(substr($content,0,$length*3));
		}
	}
	return $content;
}
/**
 * utf8去除空格
 *
 * @param string $str
 * @return string
 */
function utf8_trim($str) {
	$len = strlen($str);
	for($i=strlen($str)-1;$i>=0;$i-=1){
		$hex .= ' '.ord($str[$i]);
		$ch   = ord($str[$i]);
		if(($ch & 128)==0)	return substr($str,0,$i);
		if(($ch & 192)==192)return substr($str,0,$i);
	}
	return($str.$hex);
}
/**
 * 给数组信息转义
 *
 * @param mixed $value
 * @return mixed
 */
function addslashes_deep($value)
{
    if (empty($value)) {
        return $value;
    } else {
        return is_array($value) ? array_map('addslashes_deep', $value)
        						: addslashes(trim($value));
    }
}

/**
 * cookie编码处理
 * @param string $string 要编码的字符串
 * @param string $operation 操作ENCODE编码，DECODE解码
 * @param string $key hash值
 * @return string
 */
function authcode($string, $operation, $key = '') {
	$coded = '';
	$keylength = strlen($key);
	$string = $operation == 'DECODE' ? base64_decode($string) : $string;
	for($i = 0; $i < strlen($string); $i += $keylength) {
		$coded .= substr($string, $i, $keylength) ^ $key;
	}
	$coded = $operation == 'ENCODE' ? str_replace('=', '', base64_encode($coded)) : $coded;
	return $coded;
}

/**
 * 取服务器文档根路径
 * @return string
 */
function getRootPath() {
	$sRealPath = realpath('./');
	$sSelfPath = $_SERVER['PHP_SELF'];
	$sSelfPath = substr( $sSelfPath, 0, strrpos( $sSelfPath, '/' ));
	return substr($sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath));
}

/**
 * 把文件路径转换成URL
 * @param string $path 要转换的路径
 * @return string
 */
function pathToUrl($path) {
	$path = str_replace(getRootPath(),'',$path);
	$path = str_replace('\\','/',$path);
	$path = str_replace('//','/',$path);
	return $path;
}
/**
 * ext取分页数组
 *
 * @return array
 */
function getPageLimit()
{


	return array('test page');
	$_REQUEST['start'] = $_REQUEST['start'] ? $_REQUEST['start'] : 0;
	$_REQUEST['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : 30;
	$result['sort'] = trim($_REQUEST['property'].' '.$_REQUEST['direction']);
	if(!empty($result['sort']) && !is_null($result['sort']) && $result['sort'] <>'') $result['sort'] .= ',';
	$result['from'] = $_REQUEST['start']+1;
	$result['to']   = $result['from'] + $_REQUEST['limit']-1;
	return $result;
}

/**
 * 设置管理员的session内容
 *
 * @access  public
 * @param   integer $user_id        管理员编号
 * @param   string  $username       管理员姓名
 * @param   string  $action_list    权限列表
 * @return  void
 */
function set_admin_session($userinfo)
{
    $_SESSION['admin_id']    = $userinfo['user_id'];
    $_SESSION['admin_name']  = $userinfo['user_name'];
    $_SESSION['action_list'] = $userinfo['action_list'];
	$_SESSION['account_list'] = $userinfo['account_list'];
	$_SESSION['company'] = $userinfo['company'];
	$_SESSION['versions'] = $userinfo['versions'];
    $_SESSION['fail_order'] = 0;
    $_SESSION['login_type'] = 'erp';
    $_SESSION['app_list'] = '';
}

/**
 * 清空session内容
 *
 * @access  public
 */
function destroy_session()
{
    $_SESSION['admin_id']    = '';
    $_SESSION['admin_name']  = '';
    $_SESSION['action_list'] = '';
	$_SESSION['account_list'] = '';
	$_SESSION['company'] ='';
	$_SESSION['versions'] = '';
    $_SESSION['app_list'] = '';
    $_SESSION['fail_order'] = 0;  
    $_SESSION['login_type'] = '';
}


/**
 * 检查管理员权限
 *
 * @access  public
 * @param   string  $authz
 * @return  boolean
 */
function check_authz($authz)
{
    return (preg_match('/,*'.$authz.',*/', $_SESSION['action_list']) || $_SESSION['action_list'] == 'all');
}

/**
 * 对 MYSQL LIKE 的内容进行转义
 *
 * @access      public
 * @param       string      string  内容
 * @return      string
 */
function mysql_like_quote($str)
{
    return strtr($str, array("\\\\" => "\\\\\\\\", '_' => '\_', '%' => '\%', "\'" => "\\\\\'"));
}

function transSKU($sn)
{
		$sn1 =$sn;
		$sn = str_replace("/C",0,$sn);
		$split = explode('#',$sn);
		$arr1 = array("J","B","E","P","N","K","H","G","F","S9","S","M","D","L","CD");
		$arr2 = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15");
		$sn1 = str_replace($arr2,$arr1, substr($sn,0,2)). substr($sn,2,(strlen($split[1])==2)?(strlen($sn)-5):(strlen($sn)-4));
		if(substr($sn,-2) != '00' && (strlen($sn) == 7 ||strlen($sn) == 8) ) $sn1 .= '#'.substr($sn,(strlen($split[1])==2)?'-2':'-1');
		else $sn1 .=substr($sn,-2);
		if(strlen($sn1)>6 && substr($sn1,-2) == '00') $sn1 = substr($sn1,0,-2);
		return $sn1;	
}

function getbySKU($sku)
{
		$sku = str_replace("/C",0,$sku);
		$arr1 = array("J","B","E","P","N","K","H","G","F","S9","S","M","D","L","CD");
		$arr2 = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15");
		$sku = str_replace($arr1,$arr2, substr($sku,0,1)). substr($sku,1);
		return $sku;
}

/**
 * 对 Extjs传入数据进行解读
 *
 */
function savePost($arr,$file='test.html'){
	
}



function translate($text, $language = 'zh-CN|en'){
	if (empty($text))return false;
	@set_time_limit(0);
	$html = "";
	$ch = curl_init("http://google.com/translate_t?langpair=" . urlencode($language) . "&text=" . urlencode($text));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	$html = curl_exec($ch);
	if (curl_errno($ch))$html = "";
	curl_close($ch);
	if (!empty($html)){
		$x = explode("</span></span></div></div>", $html);
		$x = explode("onmouseout=\"this.style.backgroundColor='#fff'\">", $x[0]);
		return $x[1];
	}else{
		return false;
	}
}
function arrayToObject($e){
    if( gettype($e)!='array' ) return;
    foreach($e as $k=>$v){
        if( gettype($v)=='array' || getType($v)=='object' )
            $e[$k]=(object)arrayToObject($v);
    }
    return (object)$e;
}
 
function objectToArray($e){
    $e=(array)$e;
    foreach($e as $k=>$v){
        if( gettype($v)=='resource' ) return;
        if( gettype($v)=='object' || gettype($v)=='array' )
            $e[$k]=(array)objectToArray($v);
    }
    return $e;
}
?>