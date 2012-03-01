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
        <link type="text/css" rel="stylesheet" href="content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="content/css/main.css">
        <script type="text/javascript" src="content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="content/js/bootstrap-dropdown.js"></script>
        
<!--        <script type="text/javascript">
            $("document").ready(function (){
                $("ul#action-drop li a#data_working_link").click(function()
                {
                    $.get("html/data_working.php",{},function(data){$("div#content").html(data)});
                    return false;   
                });
                $("ul#action-drop li a#data_edit_link").click(function()
                {
                    $.get("html/data_edit.php",{},function(data){$("div#content").html(data)});
                    return false;   
                });
            });
        </script>-->

    </head>
    <body>
        <?php include 'html/header-menu.php' ?>
        <!-- end header menu -->
        <!-- main content -->
        <div class="container">
            <div class="span12" id="content">
                <div class="row row-content">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
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



