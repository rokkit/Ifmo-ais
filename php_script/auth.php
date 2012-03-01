<?php
session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
    return;
}
else 
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
}
exit;
?>