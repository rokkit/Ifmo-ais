<?php
require '../auth.php';
require '../dbconnect.php';
include '../function.php';

if($_GET['confirm']=="true")//подтверждение заявки
{
    $id=  parseNumSql($_GET['id']);
    $sql="UPDATE student_choose SET confirm=2 WHERE id_student=$id";
    mysql_query($sql)or die("ERROR");
}
if($_GET['confirm']=='false')
{
    $id=  parseNumSql($_GET['id']);
    $sql="DELETE FROM student_choose WHERE id_student=$id";
    mysql_query($sql)or die("ERROR"); 
}
?>
