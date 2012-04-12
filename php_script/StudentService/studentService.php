<?php
include '../../php_script/Struct/Faculty.php';
function getBlockFaculty()
{
    $data =  Faculty::getFaculty();
    $data = json_decode($data);
    return $data;
}
?>
