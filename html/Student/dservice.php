<?php include '../../php_script/StudentService/studentService.php';
      include '../../php_script/Trans/Trans.php';
      include '../../php_script/Student/Student.php';
      
?>
<title>Результаты</title>

<div class="row span9">
    <div id="choose-info" class="span4">
    <h2>Вы выбрали:</h2>
    <ul class="">
        <?php $direction=getFullInfoDirection($_REQUEST['direction']); ?>
        <li>Факультет:<?= Faculty::getName($direction->faculty) ?></li>
        <li>Кафедра:<?= Cathedra::getName($direction->cathedra) ?></li>
        <li>Направление:<?= $direction->name." ".$direction->description ?></li>
        <li>Форма обучения:</li>
        <li>Примерная стоимость:</li>
    </ul>
    </div>
<div class="span8">
    
</div>
    
</div>
<div class="row span9">
<h2>Оценки, на первом курсе</h2>
<div class="points">
    <?php
    $ifmodb=  connectToIfmoDb();
    $fspodb= connectToFspoDB();
    $student_id=$_COOKIE['idst'];
    $transfers = Trans::getTransfersByIdDirection($direction->id);
    $disciplines = Trans::getDisciplinesByDirection($direction->id, $ifmodb);
    $student=Student::getStudentById($student_id);
    ?>
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
        <script>
            $(function() {
                
            })
        </script>
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
</div>
</div>