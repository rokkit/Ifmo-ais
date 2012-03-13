<?php
function parseNumSql($num)
{
    $num =  mysql_escape_string($num);
    if(preg_match("/^[0-9]+$/", $num))
    {
        return $num;
    }
    return null;
}
    function connectToFspoDB()
    {
        $dbhost="localhost";
        $dbname="ifmodb";
        $dbuser="root";
        $dbpass="1405";
        $fspodb=mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
        mysql_select_db($dbname,$fspodb);
        mysql_query("set names utf8") or die('UTF8 ERROR');
        return $fspodb;
    }
    function connectToIfmoDb()
    {
        $dbhost="localhost";
        $dbname="ifmodb";
        $dbuser="root";
        $dbpass="1405";
        $ifmodb=mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
        mysql_select_db($dbname,$ifmodb);
        mysql_query("set names utf8") or die('UTF8 ERROR');
        return $ifmodb;
    }    

?>
