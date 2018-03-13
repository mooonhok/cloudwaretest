<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/27
 * Time: 15:17
 */

require 'Slim/Slim.php';
require 'connect.php';


\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->post('/addInventoryLoc',function()use($app) {
    $app->response->headers->set('Content-Type', 'application/json');
    $tenant_id = $app->request->headers->get("tenant-id");
    $body = $app->request->getBody();
    $body = json_decode($body);
    $database = localhost();
    $inventory_loc_name = $body->inventory_loc_name;
    $inventory_loc_id = $body->inventory_loc_id;
    $array = array();
    foreach ($body as $key => $value) {
        $array[$key] = $value;
    }
    if($tenant_id!=null||$tenant_id!=''){
       if($inventory_loc_name!=null||$inventory_loc_name!=''){
           if($inventory_loc_id!=null||$inventory_loc_id!=''){
               $array['tenant_id']=$tenant_id;
               $array['exist']=0;
               $insertStatement = $database->insert(array_keys($array))
                   ->into('inventory_loc')
                   ->values(array_values($array));
               $insertId = $insertStatement->execute(false);
               echo json_encode(array("result" => "0", "desc" => "success"));
           }else{
               echo json_encode(array("result" => "1", "desc" => "缺少库位id"));
           }
       }else{
           echo json_encode(array("result" => "2", "desc" => "缺少库位名字"));
       }
    }else{
        echo json_encode(array("result" => "3", "desc" => "缺少租户id"));
    }
});

$app->get('/getInventoryLocs0',function()use($app){
    $app->response->headers->set('Content-Type', 'application/json');
    $tenant_id = $app->request->headers->get("tenant-id");
    $database = localhost();
    if($tenant_id!=null||$tenant_id!=''){
        $selectStatement = $database->select()
            ->from('inventory_loc')
            ->where('tenant_id', '=', $tenant_id)
            ->where('exist','=',0)
            ->orderBy('inventory_loc_name');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        echo json_encode(array("result" => "0", "desc" => "success",'inventory_locs'=>$data));
    }else{
        echo json_encode(array("result" => "1", "desc" => "缺少租户id"));
    }
});

$app->get('/getInventoryLocs1',function()use($app){
    $app->response->headers->set('Content-Type', 'application/json');
    $tenant_id = $app->request->headers->get("tenant-id");
    $database = localhost();
    if($tenant_id!=null||$tenant_id!=''){
        $selectStatement = $database->select()
            ->from('inventory_loc')
            ->where('tenant_id', '=', $tenant_id)
            ->orderBy('inventory_loc_name');
        $stmt = $selectStatement->execute();
        $data = $stmt->fetchAll();
        echo json_encode(array("result" => "0", "desc" => "success",'inventory_locs'=>$data));
    }else{
        echo json_encode(array("result" => "1", "desc" => "缺少租户id"));
    }
});

$app->delete('/deleteInventoryLoc',function()use($app){
    $app->response->headers->set('Content-Type', 'application/json');
    $tenant_id = $app->request->headers->get("tenant-id");
    $database = localhost();
    $inventory_loc_id=$app->request->get('inventory_loc_id');
    if($tenant_id!=null||$tenant_id!=''){
        if($inventory_loc_id!=null||$inventory_loc_id!=''){
            $updateStatement = $database->update(array('exist'=>1))
                ->table('inventory_loc')
                ->where('tenant_id','=',$tenant_id)
                ->where('inventory_loc_id','=',$inventory_loc_id);
            $affectedRows = $updateStatement->execute();
            echo json_encode(array("result" => "0", "desc" => "success"));
        }else{
            echo json_encode(array("result" => "1", "desc" => "库位id为空"));
        }
    }else{
        echo json_encode(array("result" => "2", "desc" => "缺少租户id"));
    }
});

$app->run();

function localhost(){
    return connect();
}
?>