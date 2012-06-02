<?php
require 'auth.php';
require 'dbconnect.php';
require_once "function.php";

if(isset($_POST['update-state']))//нажата кнопка отправить на апдейт и факультет
    {
        if(isset($_POST['faculty-h']) && !isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {
        $name =  mysql_escape_string($_POST['name-input']);
        $full_name = mysql_escape_string($_POST['full-name-input']);

        mysql_query('UPDATE faculty SET name="'.$name.'" , full_name="'.$full_name.'" WHERE id='.$_POST['faculty-h']) or die('error');
        }
        elseif(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {
            $name =  $_POST['name-input'];
            $full_name = $_POST['full-name-input'];
            $dekan=  mysql_escape_string($_POST['dekan-input']);
            $desc=  mysql_escape_string($_POST['desc-input']);
            $link_fc =  $_POST['link-f-c'];
            mysql_query('UPDATE cathedra SET name="'.$name.'" , full_name="'.$full_name.'", id_faculty='.$link_fc.',dekan="'.$dekan.'",description="'.$desc.'" WHERE id='.$_POST['cathedra-h']) or die(mysql_error());
        }
        elseif(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && isset($_POST['direction-h']))
        {
            $name =  $_POST['name-input'];
            $full_name = $_POST['full-name-input'];
            $link_fc =  $_POST['link-f-c'];
            $link_cd =  $_POST['link-c-d'];
            mysql_query('UPDATE direction SET name="'.$name.'" , description="'.$full_name.'",  id_cathedra='.$link_cd.' WHERE id='.$_POST['direction-h']) or die('error');
        }
        echo "Изменения внесены";
    }
    elseif(isset($_POST['delete-state']))
    {
        if(isset($_POST['faculty-h']) && !isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {
            mysql_query('DELETE FROM faculty WHERE id='.$_POST['faculty-h']) or die('error');
        }
        if(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {
            mysql_query('DELETE FROM cathedra WHERE id='.$_POST['cathedra-h'].' AND id_faculty='.$_POST['faculty-h']) or die('error');
             echo "Кафедра удалена";
        }

        if(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && isset($_POST['direction-h']))
        {
            mysql_query('DELETE FROM direction WHERE id='.$_POST['direction-h'].' AND id_cathedra='.$_POST['cathedra-h']) or die('error');
            echo "Направление удалено";
        }

    }
    elseif(isset($_POST['create-state']))
    {
        if(isset($_POST['faculty-h']) && !isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {//создать факультет
        $name =  mysql_escape_string($_POST['name-input']);
        $full_name = mysql_escape_string($_POST['full-name-input']);
        $dekan=  mysql_escape_string($_POST['dekan-input']);
        $desc=  mysql_escape_string($_POST['desc-input']);
        mysql_query("INSERT INTO faculty (name, full_name,dekan,description) VALUES('$name','$full_name','$dekan','$desc')") or die("Error");
        echo "Запись добавлена";

        }
        if(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && !isset($_POST['direction-h']))
        {//создать кафедру
        $name =  $_POST['name-input'];
        $full_name = $_POST['full-name-input'];
        $desc=$_POST['desc-input'];
        $link_fc=$_POST['faculty-h'];
        $site=parseNumSql($_POST['site-input']);
        mysql_query("INSERT INTO cathedra (name, id_faculty, full_name,dekan,description,site) VALUES('$name','$link_fc','$full_name','$dekan','$desc','$site')") or die(mysql_error());
        echo "Запись добавлена";

        }
        if(isset($_POST['faculty-h']) && isset($_POST['cathedra-h']) && isset($_POST['direction-h']))
        {//создать направление
        $name =  $_POST['name-input'];
        $full_name = $_POST['full-name-input'];
        $price=  mysql_escape_string($_POST['price-input']);
        $desc=  mysql_escape_string($_POST['desc-input']);
        $link_cd=$_POST['cathedra-h'];
        mysql_query("INSERT INTO direction (name, id_cathedra, description, price) VALUES('$name',$link_cd,'$full_name','$price')") or die("Error add dir");
        echo "Направление добавлено";
        }
    }
?>
