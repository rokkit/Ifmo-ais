<?php
if($_SERVER['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest') {
    require_once '../Struct/Cathedra.php';
    require_once '../function.php';
    if(isset($_GET['id'])) {
        echo Cathedra::getZav($_GET['id']);
    }
}