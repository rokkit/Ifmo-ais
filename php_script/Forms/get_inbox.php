<?php
require '../auth.php';
require '../dbconnect.php';
include '../Student/Student.php';
$page = 1; // The current page
$sortname = 'name'; // Sort column
$sortorder = 'asc'; // Sort order
$qtype = ''; // Search column
$query = ''; // Search string



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
$result=mysql_query("SELECT * FROM student_choose WHERE confirm=0 
    $searchSql ",$ifmodb);
    while($row = mysql_fetch_array($result))
    {
        $cathedra=$row['id_cathedra'];
        $cath=mysql_query("SELECT name FROM cathedra WHERE id=$cathedra",$ifmodb);
        if($cath = mysql_fetch_array($cath)) $name_cathedra=$cath[0];
        $direction=$row['id_direction'];
        $dir=mysql_query("SELECT name FROM direction WHERE id=$direction",$ifmodb);
        if($dir) $name_direction=  mysql_result ($dir, 0); 
        //получаем фио студента сделавшего заявку
        $student = Student::getStudentById($row['id_student']);
        
        if($row['form_education']==0) $form_education="Дневная"; else $form_education="Вечерняя";
        $data['rows'][]=array('id' => $row['id_student'],
                             'cell'=>array($student->getFio(),$name_cathedra,$name_direction,$form_education));
    }
    echo json_encode($data);
?>
