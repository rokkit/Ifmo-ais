<?php
session_start();
$dbhost="localhost";
$dbname="ifmodb";
$dbuser="root";
$dbpass="1405";
mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
mysql_select_db($dbname) or die("select error");
mysql_query("set names utf8") or die('UTF8 ERROR');

    $pass =  mysql_escape_string($_POST['pass']);
    //$pass=sha1($pass);
    if(strlen($_POST['login'])>3 || strlen($pass)>3)
    {
        $query='SELECT id FROM users WHERE login="'.mysql_escape_string($_POST['login']).'" AND pass="'.$pass.'"';
        $result_q=mysql_query($query);
        if($r=mysql_fetch_assoc($result_q))
        {
            
        $_SESSION['user_id'] = $r['id'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        echo '<script>document.location.href="main.php"</script>';
        exit;
        }
        else
        {
            ?>
<script>
    $("#login-input").addClass("error");
    $("#pass-input").addClass("error");
    $("#error #pass-error").css("visibility", "visible");
    $("#error #error-login").css("visibility", "visible");
</script>
             <?php
        }
   }
   
?>