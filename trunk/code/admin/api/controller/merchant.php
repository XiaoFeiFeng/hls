<?php

/**
 * User: 冯晓飞
 * Date: 2016/1/15
 * Time: 13:54
 */
class merchant extends Controller
{
    private $merchant;

    function __construct()
    {
        parent::__construct();
        $this->merchant = new merchantModel();
    }
    //region merchant
    //申请
    function apply()
    {
        $data = postData();
        $result = $this->merchant->save('merchants', $data);
        echo $this->json->encode($result);
    }

    //查询所有菜单
    function upload()
    {
        $path = str_replace('admin/api/', '', CFG_PATH_ROOT) . 'images/merchants/' . date('ymd', time()) . "/";
        require(CFG_PATH_ROOT . 'lib/util/UploadFile.class.php');
        $upload = new UploadFile();
        try {
            $filePaths = array();
            if (!is_array($_FILES['upload']['error'])) {
                $filePaths[] = $path . $upload->upload($_FILES['upload'], $path, 1);
            } else {
                foreach ($_FILES['upload']['error'] as $k => $v) {
                    $file["error"] = $_FILES['upload']['error'][$k];
                    $file["name"] = $_FILES['upload']['name'][$k];
                    $file["size"] = $_FILES['upload']['size'][$k];
                    $file["tmp_name"] = $_FILES['upload']['tmp_name'][$k];
                    $file["type"] = $_FILES['upload']['type'][$k];
                    $filePaths[] = $path . $upload->upload($file, $path, 1);
                }
            }

            echo $this->json->encode(array("success" => true, "paths" => $filePaths));
            exit;
        } catch (Exception $e) {
            echo $this->json->encode(array('success' => false, 'error' => $e->getMessage()));
            exit;
        }
    }
//endregion
}