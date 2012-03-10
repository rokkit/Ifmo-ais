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
                                    <a href="inbox.php"><i class="icon-inbox"></i>Заявки <?php include 'get_inbox_choose.php'; ?></a>
                                </li>
                            </ul>
                            <div class="span3 well" style="width: 200px;">
                                <form>
                                    <label for="year-sel">Год</label>
                                    <select id="year-sel" name="year-sel" class="span2">
                                        
                                    </select>
                                    <label for="group-sel">Группа</label>
                                    <select id="group-sel" name="group-sel" class="span2">
                                        
                                    </select>
                                     <label for="only-choosed">С указанным направлением</label>
                                     <input type="checkbox" id="only-choosed" name="only-choosed"/>
                                </form>
                            </div>
                        </div>
                        
                        <div class="span6">
                            <div id="fcd-content">
                                <div class="studs-table" id="studs-table">
                                    <a href="/php_script/Student/get_student.php?id=1">Student 1231</a>
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
$.container = '#studs-table';
      $('a').pjax('#studs-table');
    })
  </script>
        <!-- Таблица студентов
        <script>
        $(function(){
            
       $("div#studs-table").flexigrid({
           url:'/php_script/Forms/get_studs.php',
           dataType: 'json',
           colModel : [
                        
                        {display: 'ФИО', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Кафедра', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Направление', name : 'name', width : 150, sortable : true, align: 'left'}
                        
           ],
           buttons : [
                        {name: 'Подтвердить', bclass: 'create', onpress : doCommand},
                        {name: 'Удалить', bclass: 'delete', onpress : doCommand},
                        {separator: false}
                ],
           
           searchitems : [
                        {display: 'ФИО', name : 'name'}
                ],
                sortname: "name",
                sortorder: "asc",
                usepager: false,
                title: "Заявки",
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
        </script>-->
    </body>
</html>
