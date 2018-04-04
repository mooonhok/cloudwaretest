<?php
require 'Slim/Slim.php';
require 'connect.php';
require 'files_url.php';
require 'redisconfig.php';
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$arrays=array();
$arrays['port']="127.0.0.1";
$redis=new Redis($arrays);

$app->get('/alltenants',function()use($app,$redis) {
    $app->response->headers->set('Access-Control-Allow-Origin', '*');
    $app->response->headers->set('Content-Type', 'application/json');
    $sales_id = $app->request->get("sales_id");
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

//加密
function encode($string , $skey ) {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key < $strCount && $strArr[$key].=$value;
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}
?>
