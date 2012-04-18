<?php
session_start();
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
function checkFavourite($id) {
    $cookie_name='favourites'.$_SESSION['user_id'];//название+айди студента+айди направления
    if(isset($_COOKIE[$cookie_name]))
        {//если уже добавлено в избранное то выводим класс удалить и наоборот
        $pos=strpos($_COOKIE[$cookie_name], $id);
        if($pos!==false)
            echo "remove";
        else echo "add";
    }
    else echo "add";
    
}


?>
