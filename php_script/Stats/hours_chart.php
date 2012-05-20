<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
require_once FNPATH.'function.php';
if(isset($_GET['discipline'])) {
    //запрос статистики по дисциплине
    $name=  strip_tags($_GET['discipline']);
    $name = htmlspecialchars($name);
    $name=  mysql_escape_string($name);

    $sql="SELECT id_direction,hours,aud_hours FROM discipline WHERE name='$name'";//дисицплины на разных направлениях

    $ifmodb=  connectToIfmoDb();
    $result=  mysql_query($sql, $ifmodb) or die(mysql_error());
    $data=array();
    while($disp = mysql_fetch_assoc($result)) {
        $data[]=array(array((int)($disp['hours']-$disp['aud_hours']),(int)$disp['aud_hours']),array("label"=>$disp['id_direction']));
    }
    //var_dump($data);
    //$data=array(array(array(1.0,0.5),array("label"=>"label")),array(array(1.0,0.8),array("label"=>"label2")),array(array(1.0,0.3),array("label"=>"label3")));
    echo json_encode($data);

}
?>
