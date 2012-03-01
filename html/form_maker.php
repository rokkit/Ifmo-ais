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
        <link type="text/css" rel="stylesheet" href="../content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="../content/css/main.css">
        <script type="text/javascript" src="../content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="../content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="../content/js/bootstrap-dropdown.js"></script>
    </head>
    <body>
        <?php include ('header-menu.php'); ?>
        <!-- end header menu -->
        <!-- main content -->
        <div class="container">
            <div class="span12" id="content">
                <h1>Формирование выписок</h1>
<div class="row row-content">
    <div class="span4 well" id="filter-container">
        <form id="filter-form" name="filter-form">
        <select>
            <option disabled>Год обучения</option>
        </select>
        </form>
    </div>
    <div class="span8 well">
        span8
    </div>
</div>
                <h1 id="title"></h1>
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
