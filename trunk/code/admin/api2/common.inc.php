<?php
// +--------------------------------------------------------------+
// | 这个文件是 EPR 项目的一部分                                   |
// +--------------------------------------------------------------+
// | Copyright (c) 2012 - 2015  
// |                                                              |
// | 要查看完整的版权信息和许可信息，请查看源代码中附带的 COPYRIGHT 文件  |
// +--------------------------------------------------------------+


/**
 * 公共包含文件
 *
 * @copyright Copyright (c) 2010 - 2015
 * @package Common
 * @version v0.1
 */



require('common/lib/util/Util.inc.php');
require('common/App.class.php');
require('common/Controller.class.php');
require('common/Model.class.php');

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');
@header('content-Type: text/html; charset=utf-8');

error_reporting(E_ALL & ~E_NOTICE & ~E_NOTICE);

//error_reporting(0);

/**
 *  对用户传入的变量进行转义操作。
 */
if (!get_magic_quotes_gpc()) {
    if (!empty($_GET)) {
        $_GET  = addslashes_deep($_GET);
    }
    if (!empty($_POST)) {
        $_POST = addslashes_deep($_POST);
    }

    $_COOKIE   = addslashes_deep($_COOKIE);
    $_REQUEST  = addslashes_deep($_REQUEST);
}


/** 
 * 数据库连接
 */

require_once('common/lib/db/DB.Mongo.php');
try {
    //$db = new mongoHelper();
	$db = array('test_db');
    App::setRegistry('db',$db);
} catch (DbException $e) {
	// 数据库出错处理处
	echo '数据库连接出错';
	exit;
}


?>
