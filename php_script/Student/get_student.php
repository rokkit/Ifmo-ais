<?php
if (isset($_SERVER['HTTP_X_PJAX']))
{   
    //require '../dbFspoConnect.php';
    include '../function.php';
    include 'Student.php';
    include '../Trans/Trans.php';
    
  if(isset($_GET['id']) && $_GET['id']!=null)
  {
      $fspodb = connectToFspoDB();
      $ifmodb = connectToIfmoDb();
      $id =  parseNumSql($_GET['id']);
      $student =  Student::getStudentById($id);//получаем студента со всей инфой
      $choose = Trans::getStudentChooseByIdStudent($student->id,$ifmodb);//получаем его выбранное направление и кафедру
      if($choose) 
      {
          $transfers = Trans::getTransfersByIdDirection($choose['id_direction']);//плучаем переход для него для этого направления
          $disciplines = Trans::getDisciplinesByDirection($choose['id_direction'], $ifmodb);
      }
//вывод информации о студенте
      ?>
<div>
  <div id="stud-info">    
    ФИО: <?= $student->getFio() ?>
    Группа: <?= $student->group ?>
    Программа: <?= ($student->programm==0) ? "Непрерывная" : "Базовая" ?>
    Выбранная кафедра: <?= $choose['name_cathedra']." ".$choose['full_name_cathedra'] ?>
    Выбранное направление: <?= $choose['name_direction']." ".$choose['full_name_direction'] ?>
  </div>
    <?php if($transfers) {?>
    <div id="stud-predmet">
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Предмет СПО</th>
                    <th>Предмет ВПО</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($disciplines as $discipline) //формируем таблицу соотсвествия предметов и дисциплин
                {
            ?>
                <tr><!--Формируем таблицу дисциплин и соответствующих предметов-->
                    <td><?= Trans::getSubjectByDiscipline($discipline, $fspodb, $ifmodb) ?></td>
                    <td><?= Trans::getDisciplineById($discipline, $ifmodb) ?></td>
                </tr>
            <?php
                } 
            ?>
            </tbody>
        </table>
    </div>
    <?php } ?>
</div>
      <?php
  }
}
else {
    echo "Ne";
}
?>
