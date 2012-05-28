<?php
include_once '../../php_script/function.php';
if(isset($_REQUEST['id_student']))
{
    $student_id=  parseNumSql($_REQUEST['id_student']);
    $direction_id= parseNumSql($_REQUEST['id_direction']);
    $education_form=  parseNumSql($_REQUEST['edu_form']);
    if($_COOKIE['servstart']!=2)
        $query="INSERT INTO student_choose SET id_student=$student_id,id_direction=$direction_id,confirm='1'";
    else
        $query="UPDATE student_choose SET id_direction=$direction_id  WHERE id_student=$student_id";
    $linkifm=connectToIfmo();
    $linkifm->query($query);
    //mysql_query($query,  connectToIfmoDb()) or die(mysql_error());

}
?>
