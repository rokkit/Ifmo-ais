<?php include '../../php_script/StudentService/studentService.php'; setcookie("idst",1); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ФСПО ИТМО | Сервис подачи заявлений</title>
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/student-main.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
        <script>
$(function(){
    $("ul#content-nav li").click(function(){
        $(this).addClass("current-nav").prev().removeClass("current-nav");       
    });
});        
        </script>
  <script type="text/javascript">
    $(function(){
      // pjax
$.hash = '#!/';
$.siteurl = '<?php echo $_SERVER['HTTP_HOST']; ?>';
$.container = '#st-content';
            $('.fc-block').click(function(){       
                $('div.fc-block').pjax({
                url:'cservice.php?faculty='+$(this).attr("id"),
                container:'#st-content'});//аякс запрос кафедр
            })
    })
  </script>
    </head>
    <body>
   
        <div class="container">
         <div class="row step-nav-row">
            <ul id="content-nav">
                <li class="current-nav" id="step1">
                    <a title>
                        <em>Шаг 1</em>
                        <span>Выбор факультета</span>
                    </a>
                </li>
                <li id="step2">
                    <a>
                        <em>Шаг 2</em>
                        <span>Выбор кафедры</span>
                    </a>
                </li>
                <li id="step3">
                    <a>
                        <em>Шаг 3</em>
                        <span>Выбор направления</span>
                    </a>
                </li>
                <li id="step4">
                    <a>
                        <em>Шаг 4</em>
                        <span>Планируемая успеваемость</span>
                    </a>
                </li>
                <li class="last-nav" id="step5">
                    <a>
                        <em>Шаг 5</em>
                        <span>Подача заявки</span>
                    </a>
                </li>
            </ul>
            <div class="clearboth">              
            </div>
             <div class="page-header span8">
                    <h3>Выбор факультета определит <br> общее направление будущей специальности</h3>
             </div>
         </div>
            <div class="row" id="st-content-row">
                <div id="st-content">
                    <div class="row">
                        <?php $facultys = getBlockFaculty(); ?>
                        <?php foreach($facultys as $f) {?>
                        <div class="fc-block well" id="<?= $f->id ?>">
                            <div class="span2 img">
                               Image 
                            </div>
                            <div class="span4">
                                <?= $f->name ?>
                                <?= $f->description ?>
                            </div>
                        </div>
                        <?php } ?>
                    </div>                   
                </div>
            </div>
            
        </div>
        <div class="row footer well">
                
        </div>
    </body>
</html>