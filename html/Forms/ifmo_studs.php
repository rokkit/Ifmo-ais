<?php require '../../php_script/auth.php'; ?>
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
    <script type="text/javascript" src="/content/js/admin-function.js"></script>
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
                <div class="row-fluid">
                    <div class="span3">
                        <ul class="nav nav-list">
                            <li>
                                <a href="form_maker.php"><i class="icon-file"></i>Студенты</a>
                            </li>
                            <li>
                                <a href="inbox.php"><i class="icon-inbox"></i>Заявки <?php include 'get_inbox_choose.php'; ?></a>
                            </li>
                            <li class="active">
                                <a href=""><i class="icon-th-list icon-white"></i>Поступившие студенты</a>
                            </li>
                        </ul>
                    </div>
                    <div class="span6">
                        <div id="fcd-content">
                            <div id="inbox-table">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Таблица заявок -->
<script>
    $(function(){

        $("div#inbox-table").flexigrid({
            url:'/php_script/Forms/ifmo_studs.php',
            dataType: 'json',
            colModel : [

                {display: 'ФИО', name : 'name', width : 200, sortable : true, align: 'left'},
                {display: 'Факультет', name : 'name', width : 50, sortable : true, align: 'left'},
                {display: 'Кафедра', name : 'name', width : 150, sortable : true, align: 'left'},
                {display: 'Направление', name : 'name', width : 50, sortable : true, align: 'left'}
            ],
            buttons : [
                {name: '<i class="icon-check"></i>Отчислен', bclass: 'create', onpress : doCommand}
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
        if (com == '<i class="icon-check"></i>Отчислен') {
            $('.trSelected', grid).each(function() {
                var id = $(this).attr('id');
                id = id.substring(id.lastIndexOf('row')+3);
                $.get("/php_script/Forms/ifmo_studs.php",{id:id,"delete":"true"},
                    function()
                    {
                        $("div#inbox-table").flexReload();
                        createAutoClosingAlert("#alert-save",2000);
                    });

            });
        }

    }
</script>
</body>
</html>
