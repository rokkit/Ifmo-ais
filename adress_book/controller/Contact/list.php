<?php
if(strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $link = new mysqli("localhost","root","","adress_book");
    if($link->connect_errno) exit();
    if(!empty($_GET['search'])) $search=" WHERE last_name='".$_GET['search']."' "; 
    if($result = $link->query("SELECT * FROM Contact $search ORDER BY last_name")) {
        $data=array();
        while($row = $result->fetch_assoc()) {
            $data[]=array("id"=>$row['id'],
                          "name"=>$row['name'],
                          "last_name"=>$row['last_name'],
                          "phone"=>$row['phone'],
                          "date"=>$row['date']);
        }
        $link->close();
        echo json_encode($data);
    }
}
?>
