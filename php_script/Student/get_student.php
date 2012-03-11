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
      $data=array('id'=>$id,
                  'name'=>$student->name,
                  'last_name'=>$student->last_name,
                  'second_name'=>$student->second_name,
                  'group'=>$student->group,
                  'programm'=>$student->programm);
      echo "l";
  }
}
else {
    echo "Ne";
}
?>
