<?php
session_start();
//обработка запроса на добавление в избранное
if(!empty($_POST['id']) && !empty($_POST['action']))
{
    $favs=array();
    $cookie_name='favourites'.$_SESSION['user_id'];
    if(isset($_COOKIE[$cookie_name]))
    {
       $favs=$_COOKIE[$cookie_name];
       
       $favs.=", ".$_POST['id'];
       
       if(setcookie ($cookie_name,$favs,time()*3600,"/")) echo "OVERSET $cookie_name";
       var_dump($_COOKIE[$cookie_name]);
    }
    else if(setcookie($cookie_name,$_POST['id'],time()*3600,"/")) echo "SET $cookie_name";

}
?>
