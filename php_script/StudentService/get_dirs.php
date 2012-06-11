<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require_once FNPATH.'auth.php';
require_once FNPATH.'function.php';
$ifmodb=connectToIfmo();
$data=array();
$sql="";
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      if($_GET['type']=='only') {
        $result=$ifmodb->query("SELECT id_direction FROM student_choose GROUP BY id_direction");
        while($d = $result->fetch_array()) {
            $key=$d['id_direction'];
            $key=parseNumSql($key);
            $direction=Direction::getDirectionObj($key);
            $name=$direction->name;
            $data[$key]=$name;
        }
        //var_dump($data);

        //$data=array("Section1"=>10,"Section2"=>15,"Section3"=>30,"Section4"=>40,"Section5"=>60,"Section6"=>30,"Section7"=>30,"Section8"=>30,"Section9"=>30,"Section10"=>30,"Section11"=>30,"Section12"=>30,"Section13"=>30,"Section14"=>30);
    }
}

if($result=$ifmodb->query("SELECT id,name,description FROM direction")){
    while($r=$result->fetch_array()) {
        $data[]=array('id'=>$r['id'],'name'=>$r['name']." ".$r['description']);
    }
    echo json_encode($data);
}
