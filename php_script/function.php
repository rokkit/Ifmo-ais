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


?>
