<?php
$dbhost="localhost";
$dbname="ifmodb";
$dbuser="root";
$dbpass="1405";
$fsdb=mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
mysql_select_db($dbname,$fsdb);
mysql_query("set names utf8") or die('UTF8 ERROR');
?>
