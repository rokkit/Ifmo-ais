<?php
session_start();
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require_once FNPATH.'auth.php';
require_once FNPATH.'function.php';

$ifmodb=connectToIfmoDb();
$fspodb=connectToFspoDB();

include '../Student/Student.php';
$page = 1; // The current page
$sortname = 'name'; // Sort column
$sortorder = 'asc'; // Sort order
$qtype = ''; // Search column
$query = ''; // Search string

if(isset($_GET['id']) && isset($_GET['state_ifmo'])) {
    $id=parseNumSql($_GET['id']);
    $state=parseNumSql($_GET['state_ifmo']);
    mysql_query("UPDATE student_choose SET state_ifmo=$state WHERE id_student=$id",$ifmodb) or die(mysql_error());
    exit();
}


// Get posted data
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
$sortSql = "order by $sortname $sortorder";
$searchSql = ($qtype != '' && $query != '') ? " AND $qtype = '$query'" : '';
// Get total count of records
$sql = "select count(*)
from student_choose
$searchSql";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$total = $row[0];

$data = array();

$data['total'] = $total;
$data['rows'] = array();
$result=@mysql_query("SELECT * FROM student_choose WHERE confirm=2 AND state_ifmo=1
    $searchSql ",$ifmodb);
    while($row = @mysql_fetch_array($result))
    {


        $direction=$row['id_direction'];
        $dir=mysql_query("SELECT name,id_cathedra FROM direction WHERE id=$direction",$ifmodb);
        if($dir =  mysql_fetch_assoc($dir))
        {
            $name_direction= $dir['name'];

            $cathedra =  $dir["id_cathedra"];
        }
        $cath=@mysql_query("SELECT id_faculty,name FROM cathedra WHERE id=$cathedra",$ifmodb);
        if($cath = @mysql_fetch_array($cath)) $name_cathedra=$cath[1];

        $fac=@mysql_query("SELECT name FROM faculty WHERE id=".$cath['id_faculty'],$ifmodb) or die(mysql_error());
        if($fac=@mysql_fetch_array($cath)) $name_faculty=$fac['name'];
        //получаем фио студента сделавшего заявку
        $student = Student::getStudentById($row['id_student']);

        if($row['form_education']==0) $form_education="Дневная"; else $form_education="Вечерняя";
        $data['rows'][]=array('id' => $row['id_student'],
            'cell'=>array($student->getFio(),$name_faculty,$name_cathedra,$name_direction,$form_education));
    }
    echo json_encode($data);
