<?php
include_once '../../php_script/function.php';
if(isset($_REQUEST['id_student']))
{
    $student_id=  parseNumSql($_REQUEST['id_student']);
    $direction_id= parseNumSql($_REQUEST['id_direction']);
    $cathedra_id=  parseNumSql($_REQUEST['id_cathedra']);
    $education_form=  parseNumSql($_REQUEST['edu_form']);
    $query="INSERT INTO student_choose SET id_student=$student_id,id_direction=$direction_id,form_education=$education_form";
    mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
    
}
?>
