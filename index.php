<?php
session_start();
if($_GET['action']=='logout')
    session_destroy();
require_once 'php_script/function.php';
$linkfm=connectToIfmo();
if($result=$linkfm->query("SELECT state FROM users WHERE id=".$_SESSION['user_id']))
{
    $state=$result->fetch_row();
    $state=$state[0];
}
if(!isset($_SESSION['user_id'])) {
   ?>
<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="content/css/login.css">
        <link type="text/css" rel="stylesheet" href="content/css/bootstrap.css">
    
        <script type="text/javascript" src="content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="content/js/validation.js"></script>
    </head>
    <body>
        
        <!-- Ошибки ввода в форме -->
        <div id="error">
            <ul>
                <li id="error-login">Неверный логин</li>
                <li id="pass-error">Неверный пароль</li>
            </ul>
        </div>
        
        <div class="login clearfix">
            <form id="login-form"  method="POST">
                <fieldset class="well">
                    <div class="au-input">
                        <input type="text" name="login-input" id="login-input" placeholder="Логин"/>
                    </div>
                    <div class="au-input">
                        <input type="password" name="pass-input" id="pass-input" placeholder="Пароль"/>
                    </div>
                    <div>
                        <input class="btn-primary" type="submit" id="sigin" name="signin" value="Вход"/>
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
</html>

<?php
}
elseif($state==1)
{
    header("Location: http://".$_SERVER['HTTP_HOST']."/main.php");
}
elseif($state==2) {
    header("Location: http://".$_SERVER['HTTP_HOST']."/html/student/main.php");
}
?>