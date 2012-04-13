<?php
include '../../php_script/Struct/Faculty.php';
include '../../php_script/Struct/Cathedra.php';
include '../../php_script/Struct/Direction.php';
include_once '../../php_script/function.php';
function getBlockFaculty()
{
    $data =  Faculty::getFaculty();
    $data = json_decode($data);
    return $data;
}
function getBlockCathedra($faculty) 
{
    $data = Cathedra::getCathedra($faculty);
    $data = json_decode($data);
    return $data;
}
function getBlockDirection($cathedra)
{
    $data = Direction::getDirection($cathedra);
    $data = json_decode($data);
    return $data;
}
function getFullInfoDirection($direction) {
    $data = Direction::getFullInfo($direction);
    $data = json_decode($data);
    return $data;
}
function getCountStudentByIdDirection($direction)
{
    $id = parseNumSql($direction);
    $result=  mysql_query("SELECT COUNT(*) FROM student_choose WHERE id_direction=$id", connectToIfmoDb()) or die(mysql_error()); 
    
    echo mysql_result($result, 0);
    
       
        
    
        
    
}
?>
