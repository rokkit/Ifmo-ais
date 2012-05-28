<?php
if(!isset($_COOKIE['servstart']) || $_COOKIE['servstart']=="2") {
header("Location: http://".$_SERVER['HTTP_HOST']);
exit;
}
?>