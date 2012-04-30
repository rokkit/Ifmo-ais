<?php session_start() ?>
<?php include '../../php_script/function.php'; ?>
<?php $student=  parseNumSql($_SESSION['user_id']);
      $result=  mysql_query("SELECT confirm FROM student_choose WHERE id_student=$student", connectToIfmoDb()) or die(mysql_error());
      $confirm=-1;
      if($result) {
          $confirm=  mysql_result($result, 0);
      }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/student-main.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
    </head>
    <body>
        <div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#">
                        ИТМО
                    </a>
                <ul class="nav">

                </ul>
                </div>
            </div>
        </div>

        <div class="container">
                <div class="hero-unit">
                    <h1>Сервис подачи заявлений</h1>
                    <p>Лёгкий способ выбрать факультет и кафедру для поступлени в НИУ ИТМО</p>
                    <?php if($confirm==-1) { //если заявка ещё не подавалась?>
                    <p>
                        <a class="btn btn-primary btn-large" href="service.php">Начать</a>
                    </p>
                    <?php } elseif($confirm==0) {?>
                    <div>
                        <p>Поданное вами заявление ещё рассматривается, вы можете изменить свой выбор</p>
                            <div>
                                <a class="btn btn-primary btn-large" href="service.php">Изменить</a>
                            </div>
                    </div>
                    <?php } elseif($confirm==1) {?>
                    <div class="row">
                        <img src="/content/img/accepted.png" style="float:left"/>
                        <h2 style="color: #62c462">Ваше заявление одобрено</h2>
                    </div>
                    <?php } ?>
                </div>
        </div>
    </body>
</html>
