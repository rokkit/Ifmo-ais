<?php session_start();
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require_once FNPATH.'auth.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Подача заявки</title>
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/student-main.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
        <script type="text/javascript" src="/content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="/content/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="/content/js/TufteGraph/jquery.enumerable.js"></script>
        <script type="text/javascript" src="/content/js/TufteGraph/jquery.tufte-graph.js"></script>
    </head>
    <body>
    <?php include 'header-menu.php'; ?>
    <div id="content">
        <div class="container" id="head-container">
           <div class="row well  truewell">
               <div class="span3">
                   <img src="http://www.ifmo.ru/images/logo.png" alt="">
               </div>
               <div class="span8" style="text-align: center; margin:40px 0 0 -50px;">
                   <h3>Выбор направления для продолжения обучения по непрерывной программе высшего профессионального образования в НИУ ИТМО</h3>

                   <h5></h5>
                   <a  href="/html/Student/service.php" style="margin-top: 8px" class="btn btn-info btn-large">Начать</a>
               </div>

           </div>
        </div>
        <div class="container" id="wait-head-container">
            <div class="row">
                <div class="span4 well truewell">
                    <div class="span4">
                    <h3 class="st-name"></h3>
                    <dl class="dl-horizontal">
                        <dt>Год выпуска</dt>
                        <dd id="year"></dd>
                        <dt>Средний балл</dt>
                        <dd id="avg_point"></dd>
                    </dl>
                        <h3 id="status">Ваша заявка рассматривается</h3>
                        <a  id="action-btn" href="/html/Student/service.php" style="margin: 8px 0 0 245px" class="btn btn-info btn-large">Изменить</a>
                    </div>
                </div>
                <div class="span7 well truewell">
                    <h3 class="direction"></h3>
                    <dl>
                        <dt>Декан</dt>
                        <dd class="dekan"></dd>
                        <dt>Зав. кафедры</dt>
                        <dd class="zavcath"></dd>
                        <dt>Стоимость контрактного обучения</dt>
                        <dd class="cost"></dd>
                        <dt>Сайт кафедры</dt>
                        <dd><a id="site"></a></dd>

                    </dl>
                </div>
                </div>
        </div>
        <div class="container" id="ok-head-container">
            <div class="row">
                <div class="span8 well truewell">
                    <div class="span4">
                        <h2>Вы выбрали:</h2>
                        <dl class="dl-horizontal">
                            <dt>Факультет</dt>
                            <dd id="okfaculty"></dd>
                            <dt>Кафедра</dt>
                            <dd id="okcathedra"></dd>
                            <dt>Направление</dt>
                            <dd class="direction"></dd>
                        </dl>
                    </div>

                    <div class="span3" style="text-align: center">
                        <h2>Ваша заявка одобрена</h2>
                        <img src="/content/img/accepted.png" alt="">
                    </div>
                </div>
                <div class="span3 well truewell">
                    <h2>
                        Ваш средний балл: 4.75<p class="avgpoint"></p>
                    </h2>
                </div>
            </div>
        </div>
      </div>
      <script>

          //заполняем страницу данными
          $(function(){
              $.getJSON("/php_script/StudentService/getMainContent.php",{user:'<?= $_SESSION['user_id'] ?>'},function(json){
                  $(".st-name").text(json['stname'])
                      $.cookie("st-name",json['stname'], {path:"/"})

                      $("#year").text(json['year']);
                      $("#avg_point").text(json['avg_point'])
                  if(!json['confirm']) {
                      $("#head-container").show();
                      }
                  else if(json['confirm']=='1' || json['confirm']=='2') {
                      $("#wait-head-container").show()
                      //если заявка ожидается
                      $("#faculty").text(json['faculty'])
                      $("#cathedra").text(json['cathedra'])
                      $(".direction").text(json['direction'])
                  //else if(json['confirm']=='2') {
                    //  $("#ok-head-container").show()
                      //если заявка одобрена
                      //$("#okfaculty").text(json['faculty'])
                      //$("#okcathedra").text(json['cathedra'])
                      //$(".direction").text(json['direction'])
                  //}
                        $(".dekan").text(json['dekan'])
                        $(".zavcath").text(json['zavcath'])
                        $(".cost").text(json['cost']+"р/год")
                        $("#site").attr("href",json['site'])
                        $("#site").text("Перейти")
                        if(json['confirm']=='1') {
                            $("#status").text("Ваше заявление рассматривается")
                            $("#action-btn").value("Изменить")
                        }
                        else if(json['confirm']=='2') {
                            $("#status").text("Ваше заявление одобрено")
                            $("#action-btn").remove()
                        }
                  }

              })
          });
      </script>
    </body>
</html>
