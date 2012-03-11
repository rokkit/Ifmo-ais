<?php
require '../auth.php';
include 'Student.php';
include '../function.php';
Student::getStudents($_GET);
?>
