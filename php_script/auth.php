<?php
session_start();
$id=$_SESSION['user_id'];
$date=date('Ymd');
$token=sha1($id.$date);
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] AND $_SESSION['token']==$token)
{
    return;
}
else 
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
}
exit;
?>