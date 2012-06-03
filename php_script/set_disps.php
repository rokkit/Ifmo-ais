<?php
require 'dbconnect.php';
include 'function.php';


    if(isset($_POST['set_name']) && (isset($_POST['create-disp'])||isset($_POST['update-disp'])))//добавление дисциплины
    {
        $name=  mysql_escape_string($_POST['set_name']);
        if(isset($_POST['create-disp']))
        {
           $query="INSERT INTO discipline SET name='$name'";//если запрос на добавление то формируем инсерт
        }
        elseif(isset($_POST['update-disp']))
        {
           $query="UPDATE discipline SET name='$name'";//формируем запрос на апдейт
        }
//            
        if(isset($_POST['set_semester']))//продолжаем формировать запрос
        {
            $semester=  parseNumSql($_POST['set_semester']);
            $query.=",semester='$semester'";
        }
        if(isset($_POST['set_hours']))
        {
            $hours =  parseNumSql($_POST['set_hours']);
            $query.=", hours='$hours'";
        }
        if(isset($_POST['set_aud_hours']))
        {
            $aud_hours=  parseNumSql($_POST['set_aud_hours']);
            $query.=", aud_hours='$aud_hours'";
        }
        if(isset($_POST['set_point']))
        {
            $point=  parseNumSql($_POST['set_point']);
            $query.=", point='$point'";
        }
        if(isset($_POST['set_main_cathedra']))
        {
            $main_cathedra=  parseNumSql($_POST['set_main_cathedra']);
            $query.=", id_cathedra='$main_cathedra'";
        }
        if(!empty($_POST['set_direction']))
        {
            $direction=  parseNumSql($_POST['set_direction']);
            $query.=",id_direction=$direction";
        }
        if(isset($_POST['set_type']))
        {
            $type=  parseNumSql($_POST['set_type']);
            $query.=", type=$type";
        }
        if(isset($_POST['update-disp']))//был запрос на апдейт => добавляем условие по ид
        {
            $id=  parseNumSql($_POST['set_id']);
            $query.=" WHERE id='$id'";
        }
echo $query;
        mysql_query($query,connectToFspoDB()) or die(mysql_error());
    }
   
        if(isset($_GET['id']))//получено ид для редактирования или удаления
        {
            if(isset($_GET['get_update']))//редактирование дисциплины
            {
                $id =  parseNumSql($_GET['id']);
                $ar[]=array();
                $disps =  mysql_query("SELECT * FROM discipline WHERE id='$id'",connectToFspoDB()) or die('ERROR');
                if($disp = mysql_fetch_array($disps))
                {
                    $ar[]=array(id=>$disp[0]);
                    $ar[]=array(name=>$disp[1]);
                    $ar[]=array(hours=>$disp[2]);
                    $ar[]=array(aud_hours=>$disp[3]);
                    $ar[]=array(point=>$disp[4]);
                    $ar[]=array(type=>$disp[5]);
                    $ar[]=array(id_cathedra=>$disp[6]);
                    $ar[]=array(id_direction=>$disp[7]);
                    $ar[]=array(semester=>$disp[8]);
                }
                echo json_encode($ar);
            }
        }
        if(isset($_GET['id']) && isset($_GET['get_delete']))//получение ид и вывод названия дисциплины для удаления
        {
            
            $id = parseNumSql($_GET['id']);
            $disps = mysql_query("SELECT name FROM discipline WHERE id='$id'") or die("ERROR DELETING");
            if($disp =  mysql_fetch_array($disps))
            {
                //DELETING INFO
                echo "<div class='modal-body'>";
                echo "<h2>$disp[0]</h2>";
                echo "<input type='hidden' value='$id'/>";
                echo "</div>";
                echo "<div class='modal-footer'>
                    
        <input type='submit' id='delete-disp-btn' class='btn btn-danger' value='Удалить'/>
        <a href='#' class='btn' data-dismiss='modal'>Отмена</a>
    
                      </div>
                        ";
            }
        }
        if(isset($_GET['delete-disp']) && isset($_GET['set_id']))
        {
            
            mysql_query("DELETE FROM discipline WHERE id=$id");
        }
    
    ?>
