<?php
//require '../dbconnect.php';
//require '../dbFspoConnect.php';
require '../auth.php';
include '../function.php';
$page = 1; // The current page
$sortname = 'name'; // Sort column
$sortorder = 'asc'; // Sort order
$qtype = ''; // Search column
$query = ''; // Search string
if (isset($_POST['page'])) {
        $page = mysql_real_escape_string($_POST['page']);
}
if (isset($_POST['sortname'])) {
        $sortname = mysql_real_escape_string($_POST['sortname']);
}
if (isset($_POST['sortorder'])) {
        $sortorder = mysql_real_escape_string($_POST['sortorder']);
}
if (isset($_POST['qtype'])) {
        $qtype = mysql_real_escape_string($_POST['qtype']);
}
if (isset($_POST['query'])) {
        $query = mysql_real_escape_string($_POST['query']);
}
if (isset($_POST['rp'])) {
        $rp = mysql_real_escape_string($_POST['rp']);
}

$fspodb = connectToFspoDB();
$ifmodb = connectToIfmoDb();
// Setup sort and search SQL using posted data
$sortSql = "order by $sortname $sortorder";
$searchSql = ($qtype != '' && $query != '') ? "where $qtype = '$query'" : '';
// Get total count of records
$sql = "select count(*)
from discipline
$searchSql";
$result = mysql_query($sql,$ifmodb);
$row = mysql_fetch_array($result);
$total = $row[0];
// Setup paging SQL
$pageStart = ($page-1)*$rp;
$limitSql = "limit $pageStart, $rp";
// Return JSON data
$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();
if($_GET['type']=="ifmo")
{
    $direction =  mysql_escape_string($_GET['direction']);
    if($direction==NULL)
    {
    $sql = "select id, name, semester, hours, aud_hours, point, id_cathedra
from discipline
$searchSql
$sortSql
$limitSql";
    }
    else
        $sql = "select id, name, semester, hours, aud_hours, point, id_cathedra
        from discipline WHERE id_direction=$direction
        $searchSql
        $sortSql
        $limitSql";
}
    elseif($_GET['type']=="fspo")
    {
    $sql = "select *
    from predmeti_table
    $searchSql
    $sortSql";
    }
    elseif($_GET['type']=="all")
    {
       $sql="SELECT * FROM transfer";
       if($_GET['direction']!=NULL)
       {
           $direction =  parseNumSql($_GET['direction']);
           $sql.=" WHERE id_direction=$direction";
       }
       $trans =  mysql_query($sql,$ifmodb) or die(mysql_error());
       while($tran =  mysql_fetch_array($trans))
       {
           $disp_name =  mysql_query("SELECT name,id_direction FROM discipline WHERE id=$tran[1]", $ifmodb) or die(mysql_error($ifmodb));
           $subj_name =  mysql_query("SELECT Name, semestr FROM predmeti_table WHERE Predmet_ID=$tran[2]", $fspodb) or die(mysql_error($fspodb));
           $dir_id=0;
           $dir_name="Общий";
           if($disp_name = mysql_fetch_array($disp_name)) { $disp_name=$disp_name['name'];}
           if($subj_name = mysql_fetch_array($subj_name)) $subj_name=$subj_name['Name'];

                if($tran[3]!=0) //если указано направление (конкретизировано)
                {
                    $dir_names = mysql_query("SELECT name FROM direction WHERE id=$tran[3]",$ifmodb) or die(mysql_error($ifmodb));//получаем название направление подготовки для перехода
                    $dir_name =  mysql_fetch_array($dir_names);
                }
                else
                {
                    $dir_name="Общий";
                }

           $data['rows'][]=array('id'=>$tran['id'],'cell'=>array($disp_name,$subj_name,$dir_name['name']));

       }
       echo json_encode($data);
       exit;
    }

    $results = mysql_query($sql);
while ($row = mysql_fetch_array($results))
    {
        if($_GET['type']=="ifmo") {
        if($row['type']==0) $type_final='Экзамен';
        elseif($row['type']==1) $type_final='Зачёт';
        elseif($row['type']==2) $type_final='Зачёт/Экзамен';

//        $cats =  mysql_query("select name from cathedra where id=".$row['id_cathedra']);
//        if($cat = mysql_fetch_assoc($cats))
//        {
//            $cathedra = $cat['name'];
//        }
        }
    if($_GET['type']=="ifmo") {
    $data['rows'][] = array(
    'id' => $row[0],
    'cell' => array($row[1], $row['semester'], $row['hours'],
                $row['aud_hours'],$type_final,$cathedra)
    );
    }
        elseif($_GET['type']=="fspo") {
            if($row['tip']==1) $final="Экзамен";
            else $final="Зачёт";
            $data['rows'][] = array(
                'id' => $row[0],
                'cell' => array($row[1],$row['semestr'], $row['chasi'], $final
                 )
            );
        }
    }
    echo json_encode($data)
?>
