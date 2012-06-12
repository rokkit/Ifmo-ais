<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
require_once FNPATH.'function.php';
if(isset($_GET['discipline'])) {
    //фспо отдаём в отдельном запросе
    if(isset($_GET['fspo'])) {
        //получаем информацию о кол-ве часов на фспо
        /*
        * у андрея всё это, а пока рандомное число
        */
        $fspo_hours=(int)rand(100,200);
        echo $fspo_hours;
        exit();
    }
    //запрос статистики по дисциплине
    $name = $_GET['discipline'];
    //$name = htmlspecialchars($name);
    //$name = mysql_escape_string($name);
    $name = substr($name, 0,-1);
    $sql="SELECT id_direction,hours,aud_hours FROM discipline WHERE name LIKE '%$name%'";//дисицплины на разных направлениях
    //$sql="select id, name, id_direction,hours,aud_hours from discipline where hours=646";
    //echo $sql;
    $ifmodb=  connectToIfmoDb();
    $result=  mysql_query($sql, $ifmodb) or die(mysql_error());
    $data=array();
    while($disp = mysql_fetch_assoc($result)) {
        $r=mysql_query("SELECT name, description FROM direction WHERE id=$disp[id_direction]") or die(mysql_error());
        $dname=mysql_result($r, 0);
        $data[]=array(array((int)($disp['hours']-$disp['aud_hours']),(int)$disp['aud_hours']),array("label"=>$dname));
//         $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));
// $data[]=array(array((int)($disp['hours']-$disp['aud_hours']+rand(20,40)),(int)$disp['aud_hours']+rand(10,25)),array("label"=>rand(134000,180000)));

    }

    //var_dump($data);
    //$data=array(array(array(1.0,0.5),array("label"=>"label")),array(array(1.0,0.8),array("label"=>"label2")),array(array(1.0,0.3),array("label"=>"label3")));
    $data[]=array(array($fspo_hours),array("label"=>"ФСПО"));
    echo json_encode($data);

}
?>
