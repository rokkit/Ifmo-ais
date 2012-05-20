<?php
require 'dbconnect.php';

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

// Setup sort and search SQL using posted data
$sortSql = "order by $sortname $sortorder";
$searchSql = ($qtype != '' && $query != '') ? "where $qtype = '$query'" : '';
// Get total count of records
$sql = "select count(*)
from discipline
$searchSql";
$result = mysql_query($sql);
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
if($_GET['direction']==null)
{
    $sql = "select id, name, semester, hours, aud_hours, point, id_cathedra
from discipline
$searchSql
$sortSql
$limitSql";
}
else
{
        $direction=$_GET['direction'];
        $sql = "select id, name, semester, hours, aud_hours, point, id_cathedra
        from discipline WHERE 
        id_direction=$direction
        $searchSql
        $sortSql
        $limitSql";
}

$results = mysql_query($sql);
while ($row = mysql_fetch_assoc($results)) {
    if($row['type']==0) $type_final='Экзамен';
    elseif($row['type']==1) $type_final='Зачёт';
    elseif($row['type']==2) $type_final='Зачёт/Экзамен';
    
    $cats =  mysql_query("select name from cathedra where id=".$row['id_cathedra']);
    if($cat = mysql_fetch_assoc($cats))
    {
        $cathedra = $cat['name'];
    }
    
$data['rows'][] = array(
'id' => $row['id'],
'cell' => array($row['id'], $row['name'], $row['semester'], $row['hours'],
                $row['aud_hours'],$type_final,$cathedra)
);
}
echo json_encode($data);
?>
