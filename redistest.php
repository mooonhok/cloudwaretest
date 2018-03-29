<?php
$redis = new Redis();
$redis->connect('127.0.0.1', 6379);
$redis->set('cat', 10);
$key_1 = $redis->get('cat');
echo $key_1;
?>
