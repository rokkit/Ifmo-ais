<?php
if(isset($_REQUEST['direction'])) {
include_once '../../php_script/function.php';
include_once '../../php_script/StudentService/studentService.php';
include_once '../../php_script/Trans/Trans.php';
include_once '../../php_script/Student/Student.php';

$direction_id=  parseNumSql($_REQUEST['direction']);

$direction=getFullInfoDirection($direction_id);

$name_faculty=Faculty::getName($direction->faculty);
$name_cathedra=Cathedra::getName($direction->cathedra);
$name_direction=$direction->name." ".$direction->description;
$count_num=getCountStudentByIdDirection($direction->id);

$json=array("name_faculty"=>$name_faculty,
            "name_cathedra"=>$name_cathedra,
            "name_direction"=>$name_direction,
            "count_num"=>$count_num);
echo json_encode($json);
}
?>
