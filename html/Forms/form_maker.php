<?php
require '../../php_script/auth.php';
    ?>
    <!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/main.css">
        <link type="text/css" rel="stylesheet" href="/content/flexigrid.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="/content/js/flexigrid.pack.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
    </head>
    <body>
        <?php include ('../header-menu.php'); ?>
        <!-- end header menu -->
        <!-- main content -->
        <div class="container">
            <div class="span12" id="content">
                <h1>Формирование выписок</h1>
                <div class="row row-content">
                    <div class="container-fluid">
                        <div class="span3">
                            <ul class="nav nav-list">
                                <li class="active">
                                    <a href=""><i class="icon-file icon-white"></i>Выписки</a>
                                </li>
                                <li>
                                    <a href="/html/Forms/inbox.php"><i class="icon-inbox"></i>Заявки <?php include 'get_inbox_choose.php'; ?></a>
                                </li>
                            </ul>
                            <div class="span3 well" id="filter-studs-table" style="width: 200px;">
                                <form>
                                    <label for="year-sel">Год</label>
                                    <select id="year-sel" name="year-sel" class="span2">

                                    </select>
                                    <label for="group-sel">Группа</label>
                                    <select id="group-sel" name="group-sel" class="span2">

                                    </select>
                                    <div id="only-choosed-lbl">
                                     С учётом направления
<input type="checkbox" id="only-choosed" name="only-choosed"/>
                                    </div>

                                </form>
                            </div>
                        </div>

                        <div class="span6">
                            <div id="fcd-content">
                                <div id="studs-container">
                                    <div class="studs-table" id="studs-table">
                                        <!--<a href="/php_script/Student/get_student.php?id=1">Student 1231</a>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

  <script type="text/javascript">
    $(function(){
      // pjax
$.hash = '#!/';
$.siteurl = '<?php echo $_SERVER['HTTP_HOST']; ?>';
$.container = '#studs-container';
      $('#studs-table a').pjax('#studs-container');//аякс запрос студента по ид
    })
  </script>

        <script>
        var params="params=all";//параметр запроса студентов в таблице
        //по изменению значения в фильтре изменяется параметр запроса

        $(function(){
            $("#filter-studs-table #only-choosed").change(function(){
                if($("#filter-studs-table #only-choosed").is(':checked')) params="params=choosed_direction";
                else params="params=all";
                $("div#studs-table").flexOptions({url:"/php_script/Student/get_students.php?"+params});
                $("div#studs-table").flexReload();
            });
        });

        $(function(){
       $("div#studs-table").flexigrid({ //Таблица студентов
           url:'/php_script/Student/get_students.php?'+params,
           dataType: 'json',
           colModel : [

                        {display: 'ФИО', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Группа', name : 'group', width : 50, sortable : true, align: 'left'},
                        {display: 'Программа', name : 'programm', width : 150, sortable : true, align: 'left'}

           ],

           searchitems : [
                        {display: 'ФИО', name : 'name'}
                ],
                sortname: "Familia",
                sortorder: "asc",
                usepager: false,
                title: "Студенты",
                useRp: false,
                rp: 300,
                showToggleBtn:false,
                showTableToggleBtn: false,
                resizable: false,
                width: 600,
                height: 400,
                singleSelect: false,
                minwidth:200
       });
    });

//Кнопки таблицы
    function doCommand(com, grid) {
            if (com == 'Подтвердить') {
            $('.trSelected', grid).each(function() {
            var id = $(this).attr('id');
            id = id.substring(id.lastIndexOf('row')+3);
                        $.get("../php_script/set_disps.php",{id:id,get_update:"true"},
                            function(data)
                            {
                            });

            });
            } else if (com == 'Удалить') {
                    $('.trSelected', grid).each(function() {
                    var id = $(this).attr('id');
                    id = id.substring(id.lastIndexOf('row')+3);

                    $.get("../php_script/set_disps.php", {id:id,get_delete:"true"}, function(data){
                        $("form#modal-delete").html(data);
                    });
                    $("#ModalDelDisp").modal('show');
                    });
                    }
                     else if (com == 'Добавить')
                    {
                    $("#ModalAddDisp").modal();
                    }

            }
        </script>

    </body>
</html>
