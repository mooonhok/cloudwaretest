<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->set('name','zhou', 10);
$key_1 = $redis->get('name');
echo $key_1;
?>