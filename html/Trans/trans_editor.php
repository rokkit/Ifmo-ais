<?php
session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
?>
<!DOCTYPE html>
<html>
    <head>
    <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="../../content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../../content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="../../content/css/main.css">
        <link type="text/css" rel="stylesheet" href="../../content/flexigrid.css">
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
<body> 
   <?php require '../header-menu.php'; ?>
    <!-- end header menu -->
    <div class="container">
        <div class="span12" id="content">
            <div class="row row-content">
                <div class="container-fluid">
                    <div class="row-fluid">
                        <div class="span3">
                            <h1>Переходы</h1>
                            <ul class="nav nav-list">
  <li class="nav-header">
    List header
  </li>
  <li class="active">
      <a href="trans_editor.php">Показать все</a>
  </li>
  <li>
      <a href="add_trans.php"><i class="icon-plus"></i>Добавить</a>
  </li>
  <li>
      <a href="" id="delete-trans"><i class="icon-remove"></i>Удалить</a>
  </li>
 
                            </ul>
                        </div>
                        <div class="span6" id="fcd-content">
                            <form id="trans-filter" class="form-inline trans-filter">
                                    <select id="faculty" class="input-medium" name="faculty">
                <option disabled>Факультет</option>
                <?php
    require '../../php_script/dbconnect.php';
    
                $facs=mysql_query('SELECT id,name FROM faculty');
                while($fac = mysql_fetch_assoc($facs))
                { 
                    echo '<option value="'.$fac['id'].'">'.$fac['name'].'</option>';
                }
                ?>
                                    </select>
            <select id="cathedra" class="input-medium" name="cathedra" style="display: none">
              <option disabled value>Кафедра</option>
            </select>
            <select id="direction" class="input-medium" name="direction" style="display: none">
              <option disabled value>Направление</option>
            </select>
                                </form>
                            <div id="trans-table">
                                
                            </div>
                            <div id="ModalDelDisp" class="modal hide">
                                <div class="modal-header">
                                    <h3>Удаление переходов</h3>
                                </div>
                                <div class='modal-body'>
                                <h2>Удаление выбранных переходов</h2>
                                </div>
                            <form id="modal-delete">
                                <div class="modal-footer">                                
                                    <input type='submit' id='delete-trans-btn' class='btn btn-danger' value='Удалить'/>
                                    <a href='#' class='btn' data-dismiss='modal'>Отмена</a>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- js inc -->
        <script type="text/javascript" src="../../content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../../content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="../../content/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="../../content/js/flexigrid.js"></script>
        <script type="text/javascript" src="../../content/js/bootstrap-modal.js"></script>
        <!-- js scripts-->
        <script>
           
        $(function(){
            
       $("div#trans-table").flexigrid({
           url:'../../php_script/Trans/get_trans.php?type=all',
           dataType: 'json',
           colModel : [
                        
                        {display: 'Дисциплина СПО', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Дисциплина ВПО', name : 'name', width : 150, sortable : true, align: 'left'}
                        
           ],
           
           searchitems : [
                        {display: 'Дисциплина СПО', name : 'name'},
                        {display: 'Дисциплина СПО', name : 'name'}
                ],
                sortname: "name",
                sortorder: "asc",
                usepager: false,
                title: "Переходы",
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
        </script>
        <script>
$(function()
{
        $('#faculty').chainSelect('#cathedra','../../php_script/data_edit_get.php',
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
            $('#cathedra').chainSelect('#direction','../../php_script/data_edit_get.php',
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
        $(function(){
    $("#trans-filter select").change(function(){
        var form=$("form#trans-filter").serialize();
          $("div#trans-table").flexOptions({url:'../../php_script/Trans/get_trans.php?type=all&'+form}).flexReload();  
        });
    });
    

        </script>
        <script>
$(function(){
    $("#delete-trans").click(function(){$("#ModalDelDisp").modal('show');return false;});
            });
$(function(){//on modal click do delete trans
    $("#delete-trans-btn").click(function(){
        var trans="";
        $('#trans-table .trSelected').each(function(){
                 var id = $(this).attr('id');
                 id = id.substring(id.lastIndexOf('row')+3);
                 trans+=id+"_";
             });
        $.get("/php_script/Trans/set_trans.php",{"trans":trans,"type":"delete"},function(){$("ModalDelDisp").modal('hide');});
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
