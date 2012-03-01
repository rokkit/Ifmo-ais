<?php
require 'dbconnect.php';
    $array[]=array();
    if($_GET['_name']=='faculty')
    {
        $query='SELECT id,name FROM cathedra WHERE id_faculty='.$_GET['_value'];
        $cats=mysql_query($query);
        $array[]=array($cat['0']=>'Кафедра');
        while($cat = mysql_fetch_assoc($cats))
        {
            $array[]=array($cat['id']=>$cat['name']);  
        }
    }
    elseif($_GET['_name']=='cathedra')
    {
        $query='SELECT id,name FROM direction WHERE id_cathedra='.$_GET['_value'];
        $dirs=mysql_query($query);
        $array[]=array($cat['0']=>'Направление');
        while($dir = mysql_fetch_assoc($dirs))
        {
            $array[]=array($dir['id']=>$dir['name']); 
        }
    }
    echo json_encode($array);
    ?>
