<?php
session_start();
require '../dbconnect.php';

if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
    if(isset($_POST['set']))
    {
        $ifmo_sel =  explode("_",$_POST['ifmo_sel']);
        $fspo_sel =  explode("_",$_POST['fspo_sel']);
        //$ifmo_sel=$_POST['ifmo_sel'];
        //$fspo_sel=$_POST['fspo_sel'];
    echo $fspo_sel[1];
    $sql="INSERT INTO transfer SET id_discipline=$ifmo_sel[0], id_subject=$fspo_sel[0]";
    if(isset($_POST['direction']) && $_POST['direction']!=NULL)
    {
        $direction=  mysql_escape_string($_POST['direction']);
        $sql.=", id_direction=$direction";
    }
    echo $sql;
    mysql_query($sql);
    }
}
else 
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
exit;
}
?>
