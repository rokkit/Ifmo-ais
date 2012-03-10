<?php
if (isset($_SERVER['HTTP_X_PJAX']))
{   
    require '../dbFspoConnect.php';
    include '../function.php';
    include 'Student.php';
    
  if(isset($_GET['id']) && $_GET['id']!=null)
  {
      $id =  parseNumSql($_GET['id']);
      $student =  Student::getStudentById($id);//получаем студента со всей инфой
      echo $student->name;
  }
}
else {
    echo "Ne";
}
?>
