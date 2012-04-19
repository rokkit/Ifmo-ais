<?php
include_once '../../php_script/function.php';
$ifmodb=  connectToIfmoDb();

$sql="select count(*),id_direction from student_choose group by id_direction";

$data=array("Section1"=>10,"Section2"=>15,"Section3"=>30,"Section4"=>40,"Section5"=>60);
echo json_encode($data);
?>
