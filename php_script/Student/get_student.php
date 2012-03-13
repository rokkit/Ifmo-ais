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
      $transfers = Trans::getTransfersByIdDirection($choose['id_direction']);//плучаем переход для него для этого направления
  
//вывод информации о студенте
      ?>
<div>
  <div id="stud-info">    
    Фамилия: <?= $student->last_name ?>
    Имя: <?= $student->name ?>
    Отчество: <?= $student->second_name ?>
    Группа: <?= $student->group ?>
    Программа: <?= ($student->programm==0) ? "Непрерывная" : "Базовая" ?>
    Выбранная кафедра: <?= $choose['name_cathedra']." ".$choose['full_name_cathedra'] ?>
    Выбранное направление: <?= $choose['name_direction']." ".$choose['full_name_direction'] ?>
  </div>
    <?php if($transfers) {?>
    <div id="stud-predmet">
        <table class="table-bordered">
            <thead>
                <tr>
                    <th>Предмет СПО</th>
                    <th>Предмет ВПО</th>
                </tr>
            </thead>
            <tbody>
            <?php
                foreach ($transfers as $transfer) //формируем таблицу соотсвествия предметов и дисциплин
                {
            ?>
                <tr>
                    <td><?= Trans::getSubjectById($transfer->subject, $fspodb); ?></td>
                    <td><?= Trans::getDisciplineById($transfer->discipline, $ifmodb) ?></td>
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
