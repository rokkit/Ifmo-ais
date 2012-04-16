<?php
if (isset($_SERVER['HTTP_X_PJAX']))
{   
    
    include_once '../function.php';
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
          $transfers = Trans::getTransfersByIdDirection($choose['id_direction']);//получаем переход для него для этого направления
          $disciplines = Trans::getDisciplinesByDirection($choose['id_direction'], $ifmodb);
      }
//вывод информации о студенте
      ?>
<div>
    <div class="row-fluid">
  <div id="stud-info" class="span9" style="margin-bottom: 20px;">    
    <div>ФИО: <?= $student->getFio() ?></div>
    <div>Группа: <?= $student->group ?></div>
    <div>Программа: <?= ($student->programm==1) ? "Непрерывная" : "Базовая" ?></div>
    <div>Выбранная кафедра: <?= $choose['name_cathedra']." ".$choose['full_name_cathedra'] ?></div>
    <div>Выбранное направление: <?= $choose['name_direction']." ".$choose['full_name_direction'] ?></div>
  </div>
    <?php if(!empty($choose['name_cathedra'])) { ?>
    <div class="btn-group span3">
        <a class="btn btn-large dropdown-toggle" data-toggle="dropdown" id="create-student-form-btn" href="#">
            <i class="icon-list"></i> Документы
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="../Forms/Form_docxgen/form_creator.php?type=form&id=<?=$student->id?>">Выписка</a></li>
            <li><a>Согласование</a></li>
        </ul>
    </div>
    <?php } ?>
     </div>
    <?php if($transfers) {?>
    <div id="stud-predmet">
        <table class="table table-bordered" id="stud-subject-table">
            <thead>
                <tr>
                    <th>Предмет СПО</th>
                    <th>Оценка</th>
                    <th>Предмет ВПО</th>
                </tr>
            </thead>
            <!--Формируем таблицу дисциплин и соответствующих предметов-->
            <tbody id="stud-subject-body">
            <?php
                foreach ($disciplines as $discipline) //формируем таблицу соотсвествия предметов и дисциплин
                {
            ?>
                <tr>
                    <td><?php $subject=Trans::getSubjectByDiscipline($discipline, $fspodb, $ifmodb);echo $subject['name']; ?></td>
                    <td id="point"><?php  $point=$student->getPoint($fspodb,$subject['id']); echo $point['point']; ?></td>
                    <td><?= Trans::getDisciplineById($discipline, $ifmodb) ?></td>
                </tr>
            <?php
                } 
            ?>
            </tbody>
        </table>
    </div>
        <script>//красим ячейки
            $(function(){
                $("#stud-subject-body tr").each(function(){
                    var point=parseInt($(this).children("#point").html());
                    if(point<3 || isNaN(point))
                        {
                            $(this).addClass("badResult")
                            //$(this).css("background-color", "red")
                        }
                });
            });
        </script>
    <?php } ?>
</div>
      <?php
  }
}
else {
    echo "Ne";
}
?>
