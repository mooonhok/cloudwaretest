<?php
require 'Slim/Slim.php';
require 'connect.php';
require 'files_url.php';
require 'redisconfig.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$arrays=array();
$redis=new Redis();

$app->get('/alltenants',function()use($app,$redis) {
    $app->response->headers->set('Access-Control-Allow-Origin', '*');
    $app->response->headers->set('Content-Type', 'application/json');
    $sales_id =1;
    $redis->set('name',$sales_id);
    echo $redis->get('name');
});


$app->run();

function localhost(){
    return connect();
}

function file_url(){
    return files_url();
}

?>
