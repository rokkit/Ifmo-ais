<?php
session_start();
//обработка запроса на добавление в избранное
if(!empty($_POST['id']) && !empty($_POST['action']))
{
    $cookie_name='favourites'.$_SESSION['user_id'].$_POST['id'];
    
        if($_POST['action']=="add") { 
            
            if(SetCookie($cookie_name,$_POST['id'] , time()*3600,"/")) echo "SET $cookie_name";
            else echo "NOT";
          
            }
        else if($_POST['action']=="remove") setcookie($cookie_name,"",time()-3600,"/");   
}
?>
