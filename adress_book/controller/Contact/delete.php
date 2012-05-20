<?php
    $link = new mysqli("localhost","root","","adress_book");
    $id=$_GET['id'];//из гет запроса забираем номер записи
    if($link->query("DELETE FROM Contact WHERE id=$id"));
?>
