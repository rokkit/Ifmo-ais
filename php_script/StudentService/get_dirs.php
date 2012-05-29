<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require_once FNPATH.'auth.php';
require_once FNPATH.'function.php';
$ifmodb=connectToIfmo();
$data=array();
if($result=$ifmodb->query("SELECT id,name,description FROM direction")){
    while($r=$result->fetch_array()) {
        $data[]=array('id'=>$r['id'],'name'=>$r['name']." ".$r['description']);
    }
    echo json_encode($data);
}
