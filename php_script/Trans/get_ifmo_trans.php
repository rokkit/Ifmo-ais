<?php
session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
    require '../dbconnect.php';
    
    $faculty=0;
    $cathedra=0;
    $direction=0;
    
    if(isset($_GET['faculty']) && $_GET['faculty']!=NULL)
    {
        $faculty=  mysql_escape_string($_GET['faculty']);
    }
    if(isset($_GET['cathedra'])&&$_GET['cathedra']!=NULL)
    {
        $cathedra=  mysql_escape_string($_GET['cathedra']);
    }
    if(isset($_GET['direction']) && $_GET['direction']!=NULL)
    {
        $direction=  mysql_escape_string($_GET['direction']);
    }
    ?>
<script>
     $(function(){
       $("div#ifmo-table").flexigrid({
           url:'../../php_script/get_trans.php?type=ifmo',
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
</script>
    <?php
}
else 
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
}
exit;
?>
