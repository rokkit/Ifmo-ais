<?php
if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $name=$_REQUEST['new_name'];
    $last_name=$_REQUEST['new_last_name'];
    $phone=$_REQUEST['new_phone'];
    $date=date('d.m.Y');
    $link = new mysqli("localhost","root","","adress_book");
    $sql="INSERT INTO Contact VALUES(null,'$name','$last_name','$phone','$date')";
    echo $sql;
    if($link->query($sql)) {
        echo "Запись добавлена";
    }
}
?>
