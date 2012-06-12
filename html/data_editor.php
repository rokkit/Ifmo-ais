<?php
session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
    require '../php_script/dbconnect.php';
    ?>
    <!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="../content/css/main.css">
        <link type="text/css" rel="stylesheet" href="../content/flexigrid.css">
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

    </head>
    <body>
        <?php include 'header-menu.php'; ?>
        <!-- end header menu -->
        <!-- main content -->

      <div class="container">
            <div class="span12" id="content">
              <h1 id="header-text">Редактирование</h1>

<div class="row row-content">
<div class="container-fluid">

<div class="row-fluid">
    <div class="span3">

        <div class="well">
                    <h3 class="h3-filter">Структура ВПО</h3>
        <form id="filter-form" name="filter-form">
            <div class="crud-button">
        <input type="submit" id="create" class="btn-success" value="Добавить"/>
        <input type="submit" id="update" class="btn-warning" value="Изменить"/>
        <input type="submit" id="delete" class="btn-danger" value="Удалить"/>
        <input type="hidden" id="state" name="state" value="null"/>
            </div>
            <select id="faculty" name="faculty">
                <option>Факультет</option>
                <?php


                $facs=mysql_query('SELECT id,name FROM faculty');
                while($fac = mysql_fetch_assoc($facs))
                {
                    echo '<option value="'.$fac['id'].'">'.$fac['name'].'</option>';
                }
                ?>
            </select>
            <select id="cathedra" name="cathedra" style="display: none">
              <option disabled value>Кафедра</option>
            </select>
            <select id="direction" name="direction" style="display: none">
              <option disabled value>Направление</option>
            </select>
        </form>
        </div>

    </div>

    <div class="span6" id="fcd-content">

    </div>
</div>

</div>
                </div>
            </div>
        </div>


        <script type="text/javascript" src="../content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="../content/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="../content/js/flexigrid.js"></script>
        <script type="text/javascript" src="/content/js/raphael-min.js"></script>
        <script type="text/javascript" src="/content/js/student-function.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
        <script type="text/javascript">
$(function()
{
        $('#faculty').chainSelect('#cathedra','../php_script/data_edit_get.php',
        {
                before:function (target) //before request hide the target combobox and display the loading message
                {
                        //$("#loading").css("display","block");
                        $(target).css("display","none");

                },
                after:function (target) //after request show the target combobox and hide the loading message
                {
                        //$("#loading").css("display","none");
                        $(target).css("display","inline");

                }

        });
        $("#cathedra").click(function(){
            $('#cathedra').chainSelect('#direction','../php_script/data_edit_get.php',
        {
                before:function (target) //before request hide the target combobox and display the loading message
                {
                        //$("#loading").css("display","block");
                        $(target).css("display","none");
                },
                after:function (target) //after request show the target combobox and hide the loading message
                {
                        //$("#loading").css("display","none");
                        $(target).css("display","inline");
                }
        });
        });

});
$("document").ready(function(){
$("select#cathedra").click(function(){
    $("#header-text").text("Редактирование кафедр"); $("#cathedra option:first").val(0);
    $("#state").val("cathedra");
    });
    $("select#faculty").click(function(){$("#header-text").text("Редактирование факультетов");$("#faculty option:first").val(0);
        $("#state").val("faculty");});
    $("select#direction").click(function(){$("#header-text").text("Редактирование направлений");$("#direction option:first").val(0);
    $("#state").val("direction");
        });
});
//загрузка дисциплин по изменению бокса
$(function(){
    $("select#direction").change(function(){
        $("div#fcd-content").removeClass("well");
        var direction=$("select#direction").val();
        $.get("../php_script/get_disps_table.php", {"direction":direction}, function(data) {
            $("div#fcd-content").html(data);
        });
    });
});

$("document").ready(function(){
    $("input#update").click(function(){
        $("div#fcd-content").addClass("well");
        var form=$("form#filter-form").serialize();
        $.get("../php_script/get_content_fcd.php", form+"&update=true", function(data){$("div#fcd-content").html(data);});
return false;
});
});

$("document").ready(function(){
    $("input#create").click(function(){
        $("div#fcd-content").addClass("well");
        var form=$("form#filter-form").serialize();
        $.get("../php_script/get_content_fcd.php", form+"&create=true", function(data){$("div#fcd-content").html(data);});
return false;
});
});

$("document").ready(function(){
    $("input#delete").click(function(){
        $("div#fcd-content").addClass("well");
        var form=$("form#filter-form").serialize();
        $.get("../php_script/get_content_fcd.php", form+"&delete=true", function(data){$("div#fcd-content").html(data);});
return false;
});
});
</script>
    </body>
</html>
<?php
}
else
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
}
exit;
?>
