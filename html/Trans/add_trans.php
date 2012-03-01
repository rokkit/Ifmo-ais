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
   <?php include '../header-menu.php'; ?>
    
    <div id="trans-added"  class="alert alert-success fade in alert-msg">Переход добавлен</div>
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
  <li>
      <a href="trans_editor.php">Показать все</a>
  </li>
  <li class="active">
    <a href="">Добавить</a>
  </li>
 
</ul>
                        </div>
                        <div class="span6" id="fcd-content">
                            
                            <div class="row-fluid">
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

                            </div>
                            <div class="row-fluid"><div id="trans-tables">
                                
                                <div class="span4 fspo-table">                                
                                    <div id="fspo-table">
                                    
                                    </div>
                                </div>
                                <div class="span4">
                                    <div id="ifmo-table">
                                    
                                    </div>
                                </div>
                            </div></div>
                            <div class="row-fluid" style="margin-top:25px; margin-left:-100px;"><div class="span12"><a href="" id="do-link" class="btn btn-primary do-link-btn">Связать</a></div></div>
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
        <script type="text/javascript" src="../../content/js/bootstrap-alert.js"></script>
        <!-- js scripts-->
        <script>
            var height_t=200;
        $(function(){
            
       $("div#fspo-table").flexigrid({
           url:'../../php_script/Trans/get_trans.php?type=fspo',
           dataType: 'json',
           colModel : [
                        
                        {display: 'Дисциплина', name : 'name', width : 150, sortable : true, align: 'left'}
                        
           ],
           
           searchitems : [
                        {display: 'Дисциплина', name : 'name'}   
                ],
                sortname: "name",
                sortorder: "asc",
                usepager: false,
                title: "Дисциплины СПО",
                useRp: false,
                rp: 300,
                showToggleBtn:false,
                showTableToggleBtn: false,
                resizable: false,
                width: 300,
                height: height_t,
                singleSelect: false
       }); 
    });
     $(function(){
       $("div#ifmo-table").flexigrid({
           url:'../../php_script/Trans/get_trans.php?type=ifmo',
           dataType: 'json',
           colModel : [
                        
                        {display: 'Дисциплина', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Семестр', name : 'semester', width : 70, sortable : true, align: 'left'}
                        
           ],
           
           searchitems : [
                        {display: 'Дисциплина', name : 'name'}   
                ],
                sortname: "name",
                sortorder: "asc",
                usepager: false,
                title: "Дисциплины ВПО",
                useRp: false,
                rp: 300,
                showToggleBtn:false,
                showTableToggleBtn: false,
                resizable: false,
                width: 400,
                height: height_t,
                singleSelect: false
       }); 
    });
    $(function(){
        $("#do-link").click(function(){
            var direction=$("select#direction").val();
            //var fspo_sel=new Array();
            //var ifmo_sel=new Array();
            var fspo_sel="";
            var ifmo_sel="";
             $('#fspo-table .trSelected').each(function(){
                 var id = $(this).attr('id');
                 id = id.substring(id.lastIndexOf('row')+3);
                 //fspo_sel.push(id);
                 fspo_sel+=id+"_";
             });
             $('#ifmo-table .trSelected').each(function(){
                 var id = $(this).attr('id');
                 id = id.substring(id.lastIndexOf('row')+3);
                 ifmo_sel+=id+"_";
             });
             fspo_sel=fspo_sel.substring(0, fspo_sel.length - 1);
             ifmo_sel=ifmo_sel.substring(0, ifmo_sel.length - 1);
             $.post("../../php_script/Trans/set_trans.php", {'fspo_sel':fspo_sel,
                 'ifmo_sel':ifmo_sel,'direction':direction,'set':'true'},
                  function(){
                      fspo_sel="";ifmo_sel="";
                      //$("#trans-added").show("slow").hide('slow')});
                      $("#trans-added").show("slow",function(){setTimeout(function(){$("#trans-added").hide('slow');},2500);});
                }); return false;         
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
          $("div#ifmo-table").flexOptions({url:'../../php_script/Trans/get_trans.php?type=ifmo&'+form}).flexReload();  
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

