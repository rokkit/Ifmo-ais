<?php
include '../../php_script/Struct/Faculty.php';
include '../../php_script/Struct/Cathedra.php';
include '../../php_script/Struct/Direction.php';
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
?>
