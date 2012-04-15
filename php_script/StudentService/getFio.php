<?php
if(isset($_GET['id'])) 
    {
    include '../Student/Student.php';
    Student::getFioQuery($_GET['id']);
    }
?>
