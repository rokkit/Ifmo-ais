<?php include '../../php_script/StudentService/studentService.php';
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
//require FNPATH.'StudentService/auth.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>ФСПО ИТМО | Сервис подачи заявлений</title>
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/student-main.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
        <script type="text/javascript" src="/content/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-transition.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-tooltip.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-popover.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-modal.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-tab.js"></script>
        <script type="text/javascript" src="/content/js/raphael-min.js"></script>
        <script type="text/javascript" src="/content/js/student-function.js"></script>

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
<?php include 'header-menu.php'; ?>

        <div class="container">
         <div class="row step-nav-row">
            <ul id="content-nav">
                <li class="current-nav" id="step1">
                    <a href="/html/Student/service.php">
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
             <!-- <div class="page-header span8">
                    <h3>Выбор факультета определит <br> общее направление будущей специальности</h3>
             </div> -->
         </div>
            <div class="row" id="st-content-row">
                <div id="st-content">
                    <div class="row">
                        <?php $facultys = getBlockFaculty(); ?>
                        <?php foreach($facultys as $f) {?>
                        <div class="fc-block well" id="<?php echo $f->id ?>" style="text-align: justify">
                            <strong><?php echo $f->full_name." (".$f->name.")" ?></strong><br>
                                <?php echo $f->description ?>

                        </div>

                        <?php } ?>
                    </div>
                    <script>
                        $(function() {
                            $("#content-nav").children("li").each(function(){
                               $(this).removeClass("current-nav");
                            });
                            $("#content-nav #step1").addClass("current-nav");
                        });
                    </script>
                </div>
            </div>

        </div>

        <div class="row footer well">

        </div>
    </body>
</html>
