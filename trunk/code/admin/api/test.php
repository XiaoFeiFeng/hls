<?php
//连接本地的 Redis 服务
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->auth("huliansu@2013");
echo "Connection to server sucessfully";
// 获取数据并输出
$arList = $redis->get("test");
echo "Stored keys in redis:: ";
print_r($arList);
?>