<?php
require '../auth.php';
include 'Student.php';
include_once '../function.php';
Student::getStudents($_GET);
?>
