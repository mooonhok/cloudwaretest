<?php
require 'redisconfig.php';
// 只有一台 Redis 的应用
$redis = new RedisCluster();
$redis->connect(array('host'=>'127.0.0.1','port'=>6379));


//*
$cron_id = 10001;
$CRON_KEY = 'CRON_LIST'; //
$PHONE_KEY = 'PHONE_LIST:'.$cron_id;//

//cron info
$cron = $redis->hget($CRON_KEY,$cron_id);
if(empty($cron)){

    $cron = array('id'=>10,'name'=>'jackluo');//mysql data
    $redis->hset($CRON_KEY,$cron_id,$cron); // set redis
}
//phone list
$phone_list = $redis->lrange($PHONE_KEY,0,-1);
print_r($phone_list);
if(empty($phone_list)){
    $phone_list =explode(',','13228191831,18608041585');    //mysql data
    //join  list
    if($phone_list){
        $redis->multi();
        foreach ($phone_list as $phone) {
            $redis->lpush($PHONE_KEY,$phone);
        }
        $redis->exec();
    }
}

print_r($phone_list);


/*$list = $redis->hget($cron_list,);

var_dump($list);*/
//*/


//$redis->set('id',35);

/*
    $redis->lpush('test','1111');
    $redis->lpush('test','2222');
    $redis->lpush('test','3333');

    $list = $redis->lrange('test',0,-1);
    print_r($list);
    $lpop = $redis->lpop('test');
    print_r($lpop);
    $lpop = $redis->lpop('test');
    print_r($lpop);
    $lpop = $redis->lpop('test');
    print_r($lpop);
*/
//    var_dump($redis->get('id'));

?>
