<?php
require_once 'php_script/function.php';
$linkfm = connectToIfmo();
$f = fopen('Z:\file.txt', 'r');
while ($str = fgets($f)) {

    $a = explode(";", $str);


    if (strlen($a[0]) > 1) $a[0] = 3;

    $sql="INSERT INTO discipline(id, semester, hours, id_cathedra, type, aud_hours, point,name, id_direction) VALUES (null,$a[0],$a[1],'$a[2]',$a[3],$a[4],$a[5],'$a[6]',18)";
    $linkfm->query($sql);
}
