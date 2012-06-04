<?php
session_start();
if(isset($_REQUEST['direction'])) {
include_once '../../php_script/function.php';
include_once '../../php_script/StudentService/studentService.php';
include_once '../../php_script/Trans/Trans.php';
include_once '../../php_script/Student/Student.php';
$ifmodb = connectToIfmoDb();
$fspodb = connectToFspoDB();
$direction_id=  parseNumSql($_REQUEST['direction']);

$direction=getFullInfoDirection($direction_id);

$name_faculty=Faculty::getName($direction->faculty);
$name_cathedra=Cathedra::getName($direction->cathedra);
$name_direction=$direction->name." ".$direction->description;
$count_num=getCountStudentByIdDirection($direction->id);
$price=$direction->price;
$student=Student::getStudentById($_SESSION['user_id']);

$points=array();
    $disciplines = Trans::getDisciplinesByDirection($direction->id, $ifmodb);//получаем список дисциплин
  
foreach ($disciplines as $discipline) //формируем таблицу соотсвествия предметов и дисциплин
                {
                    $subject=Trans::getSubjectByDiscipline($discipline, $fspodb, $ifmodb);
                    $point=$student->getPoint($fspodb,$subject['id']);
                    $discipline=Trans::getDisciplineById($discipline, $ifmodb);

                    $points[]=array("subject"=>$subject['name'],"point"=>$point['point'],"discipline"=>$discipline);
                }

$json=array("name_faculty"=>$name_faculty,
            "name_cathedra"=>$name_cathedra,
            "name_direction"=>$name_direction,
            "count_num"=>$count_num,
            "price"=>$price,
            "points"=>$points);

echo json_encode($json);
}
?>
