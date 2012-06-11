<?php
include_once '../../php_script/function.php';
include_once '../../php_script/Struct/Direction.php';
$ifmodb=  connectToIfmo();
//если есть список выбранных направлений
if($_GET['type']=='ch') {
    $cook=$_COOKIE['list_ids'];
    $cook=explode(";",$cook);
    $data=array();
    $d=array();
    if($_GET['graph']=='web') {
        $result=$ifmodb->query("SELECT COUNT(*),id_direction FROM student_choose GROUP BY id_direction");
        while($d = $result->fetch_array()) {
            $key=$d['id_direction'];
            $key=parseNumSql($key);
            $direction=Direction::getDirectionObj($key);
            $name=$direction->name;
            $data[$name]=rand(10,40);
        }
        //var_dump($data);

        //$data=array("Section1"=>10,"Section2"=>15,"Section3"=>30,"Section4"=>40,"Section5"=>60,"Section6"=>30,"Section7"=>30,"Section8"=>30,"Section9"=>30,"Section10"=>30,"Section11"=>30,"Section12"=>30,"Section13"=>30,"Section14"=>30);
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
echo json_encode($data);
?>
