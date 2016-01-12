<?php

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, Accept, Authorization, X-Request-With');
header('Access-Control-Allow-Credentials: true');

include_once('../../ice/common/lib/util/JSON.php');
include_once('../controller/Controller.Permission.php');

$db = new mongoHelper();

$_REQUEST['action']();

//region common function
//输出错误信息
function echoError($e)
{
    $json = new Services_JSON();
    echo $json->encode(array("success" => false, "error" => $e->getMessage()));
}

//输出数据
function echoData($data)
{
    $json = new Services_JSON();
    echo $json->encode($data);
}

function echoSuccess($data)
{
    $json = new Services_JSON();
    echo $json->encode($data);
}

//获取Post参数
function getPostData()
{
    return json_decode(file_get_contents("php://input"), true);
}

//添加
function add($table)
{
    if (empty($table)) return;
    global $db;
    $params = getPostData();
    echoData(array("success" => $db->add($table, $params)));
}

//删除
function remove($table)
{
    if (empty($table)) return;
    global $db;
    $where = array("_id" => new MongoId($_GET["id"]));
    echoData(array("success" => $db->remove($table, $where)));
}

//批量删除
function removes($table)
{
    if (empty($table)) return;
    global $db;
    $ids = array();
    foreach (getPostData() as $v) {
        $ids[] = new MongoId($v);
    }
    $where = array("_id" => array('$in' => $ids));
    echoData(array("success" => $db->remove($table, $where)));
}

//编辑
function edit($table)
{
    if (empty($table)) return;
    global $db;
    $where = array("_id" => new MongoId($_GET["id"]));
    $data = getPostData();
    echoData(array("success" => $db->edit($table, $where, $data)));
}


//查找最后一条数据
function findOne($table, $where)
{
    if (empty($table)) return;
    global $db;
    echoData(array("success" => true, "data" => $db->findOne($table, $where)));
}

//条件查找
function find($table, $where = null, $sort = null)
{
    if (empty($table) || empty($where)) return;
    global $db;

    $index = empty($_GET["pi"]) ? null : $_GET["pi"];
    $size = empty($_GET["ps"]) ? null : $_GET["ps"];
    echoData(array(
        "success" => true,
        "data" => $db->find($table, $where, $sort, $index, $size),
        "count" => $db->count($table, $where)
    ));
}

//endregion

//region admin menu
//查询所有菜单
function get_menus()
{
    try {
        $where = array('used' => true);
        $sort = array('sort' => -1);
        find("menus", $where, $sort);
    } catch (Exception $e) {
        echoError($e);
    }
}

//添加菜单
function add_menu()
{
    try {
        add("menus");
    } catch (Exception $e) {
        echoError($e);
    }
}

//删除菜单 单条
function remove_menu()
{
    try {
        remove("menus");
    } catch (Exception $e) {
        echoError($e);
    }
}

//删除菜单
function remove_menus()
{
    try {
        removes("menus");
    } catch (Exception $e) {
        echoError($e);
    }
}

//更新菜单
function edit_menu()
{
    try {
        edit("menus");
    } catch (Exception $e) {
        echoError($e);
    }
}

//endregion

//region admin user

//添加用户
function add_user()
{
    try {
        add("users");
    } catch (Exception $e) {
        echoError($e);
    }
}

//删除用户 单条
function remove_user()
{
    try {
        remove('users');
    } catch (Exception $e) {
        echoError($e);
    }
}

//删除用户批量
function remove_users()
{
    try {
        removes('users');
    } catch (Exception $e) {
        echoError($e);
    }
}

//编辑用户
function edit_user()
{
    try {
        edit("users");
    } catch (Exception $e) {
        echoError($e);
    }
}

//查询所有用户
function get_users()
{
    try {
        $where = array('used' => true);
        find("users", $where);
    } catch (Exception $e) {
        echoError($e);
    }
}

//endregion

//region admin role
//添加角色
function add_role()
{
    try {
        add("roles");
    } catch (Exception $e) {
        echoError($e);
    }
}

//编辑角色
function edit_role()
{
    try {
        edit("roles");
    } catch (Exception $e) {
        echoError($e);
    }
}

//删除角色
function remove_role()
{
    try {
        remove("roles");
    } catch (Exception $e) {
        echoError($e);
    }
}

//批量删除角色
function remove_roles()
{
    try {
        removes("roles");
    } catch (Exception $e) {
        echoError($e);
    }
}

//查找所有角色
function get_roles()
{
    try {
        $where = array('used' => true);
        find("roles", $where);
    } catch (Exception $e) {
        echoError($e);
    }
}

//endregion

//用户登录
function login()
{
    $params = getPostData();
    $params['username'];
    $params['password'];

    $user_id = "568b777ff3af6c3f083f5a56";
    $permission = new  Permission();
    $result = $permission->setUserPermissions($user_id);

    echoData(array(
        "success" => true,
        "data" => $result,
        "count" => count($result)
    ));
}

//用户登录
function test()
{

}

?>
