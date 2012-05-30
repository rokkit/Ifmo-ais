<?php
include_once '../../php_script/function.php';
$ifmodb=  connectToIfmo();
//если есть список выбранных направлений
if($_GET['type']=='ch') {
    $cook=$_COOKIE['list_ids'];
    $cook=explode(";",$cook);
    $data=array();
    if($_GET['graph']=='web') {
    foreach($cook as $c) {
        if($c>0) {
            $c=parseNumSql($c);
            $result=$ifmodb->query("SELECT COUNT(*) FROM student_choose WHERE id_direction=$c");
            $result=$result->fetch_array();
            $data[]=array('id'=>$c,'data'=>$result[0]);
        }
    }
    }
    elseif($_GET['graph']=='chart') {
        foreach($cook as $c) {
        if($c>0) {
            $c=parseNumSql($c);
            $result=$ifmodb->query("SELECT COUNT(*) FROM student_choose WHERE id_direction=$c");
            $r=$result->fetch_array();
            $result=$ifmodb->query("SELECT name FROM direction WHERE id=$c");
            $name=$result->fetch_assoc();
            $data[]=array((int)($r[0]),array("label"=>$name['name']));
        }
        }
    }
}
//$data=array("Section1"=>10,"Section2"=>15,"Section3"=>30,"Section4"=>40,"Section5"=>60);
echo json_encode($data);
?>
