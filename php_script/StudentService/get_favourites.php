<?php
if(isset($_GET['user_id']))
{
session_start();
include_once '../../php_script/function.php';
    //получаем с кук избранное и возвращаем json массив id - направление - кафедра
$cookie_name="favourites".$_SESSION['user_id'];
$favs=$_COOKIE[$cookie_name];
$json=array();

if($favs)//получаем массив айдишек направлений
{
    $ifmodb=  connectToIfmoDb();
    $favs = explode(",", $favs);
    foreach ($favs as $fav) {
        $id= parseNumSql($fav);//получаем айди направления
        $result= mysql_query("SELECT id,name,id_cathedra FROM direction WHERE id=$id", $ifmodb) or die(mysql_error());
        if($result= mysql_fetch_assoc($result))
        {
            $cathedra=$result['id_cathedra'];//по айди кафедры узнаем айди факультета
            $faculty=  mysql_query("SELECT id_faculty FROM cathedra WHERE id=$cathedra",$ifmodb) or die(mysql_error());
            $faculty=  mysql_result($faculty, 0);
            $faculty=  mysql_query("SELECT name FROM faculty WHERE id=$faculty", $ifmodb) or die(mysql_error());
            $faculty=  mysql_result($faculty, 0);//записываем имя факультета
        
            $json[]=array("id"=>$fav,"name"=>$result['name'],"name_faculty"=>$faculty);
        }
        
    }
    echo json_encode($json);
}
    
}
?>
