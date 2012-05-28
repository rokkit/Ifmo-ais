<?php
require_once "function.php";
session_start();

$linkifm=connectToFspo();


    $pass =  mysql_escape_string($_POST['pass']);
    //$pass=sha1($pass);
    if(strlen($_POST['login'])>3 || strlen($pass)>3)
    {
        $query='SELECT id,state FROM users WHERE login="'.mysql_escape_string($_POST['login']).'" AND pass="'.$pass.'"';
        $result_q=$linkifm->query($query);
        if($r=$result_q->fetch_assoc())
        {
            
        $_SESSION['user_id'] = $r['id'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
            $id=$_SESSION['user_id'];
            $date=date('Ymd');
            $token=sha1($id.$date);
        $_SESSION['token']=$token;
       // header("Location: http://".$_SERVER['HTTP_HOST']);
            if($r['state']=='1')
                echo '<script>document.location.href="main.php"</script>';
            else header("Location: http://".$_SERVER['HTTP_HOST'].'/html/Student/main.php');
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