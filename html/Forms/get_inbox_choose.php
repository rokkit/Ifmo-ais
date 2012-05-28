<?php
require '../../php_script/auth.php';
require '../../php_script/dbconnect.php';

//получение количества заявок

    $result =  mysql_query("SELECT COUNT(*) FROM student_choose WHERE confirm=1") or die("ERROR COUNTING");
    if ($result) $count = mysql_result($result,0);
    if($count!=0) echo "<b>($count)</b>";

?>
