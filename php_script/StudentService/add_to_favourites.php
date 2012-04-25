<?php
session_start();
//обработка запроса на добавление в избранное
if(!empty($_POST['id']) && !empty($_POST['action']))
{

    $cookie_name='favourites'.$_SESSION['user_id'];
    if($_POST['action']=="add")
    {
        if(isset($_COOKIE[$cookie_name]))
        {
        $favs=$_COOKIE[$cookie_name];

        $favs.=",".$_POST['id'];

        if(setcookie($cookie_name,$favs,time()+3600,"/")) echo "OVERSET $cookie_name";

        }
        else if(setcookie($cookie_name,$_POST['id'],time()+3600,"/")) echo "SET $cookie_name";
    }
    else if($_POST['action']=="remove") {

        if(isset($_COOKIE[$cookie_name]))
        {
            $favs=$_COOKIE[$cookie_name];
            $favs = explode(",", $favs);
            $key= array_search($_POST['id'],$favs);
            unset($favs[$key]);
            $favs=implode(",",$favs);
            if(setcookie ($cookie_name,$favs,time()+3600,"/")) echo "KILL $cookie_name";

        }
    }
}
?>
