<?php
session_start();
if(!empty($_GET['user'])) {
    define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
    require_once FNPATH.'function.php';
    require_once FNPATH.'Student/Student.php';
    require_once FNPATH.'StudentService/studentService.php';
    $data=array();
    $user=parseNumSql($_GET['user']);

    $linkifm=connectToFspo();
    $confirm=$linkifm->query("SELECT confirm FROM student_choose WHERE id_student=$user");
    if($confirm=$confirm->fetch_assoc()) {
        $confirm=$confirm['confirm'];
        $data['confirm']=$confirm;
    }
    if($confirm!=null) {
        $result=$linkifm->query("SELECT * FROM student_choose WHERE id_student=$user");
        if($result = $result->fetch_assoc()) {
            $direction=getFullInfoDirection($result['id_direction']);
            $data['cost']=$direction->price;
            $data['faculty']=Faculty::getName($direction->faculty);
            $fobj=Faculty::getFacultyObj($direction->faculty);
            $data['dekan']=$fobj->dekan;
            $cobj=Cathedra::getCathedraObj($direction->cathedra);
            $data['site']=$cobj->site;
            $data['zavcath']=$cobj->dekan;
            $f=Faculty::getFacultyObj($direction->faculty);
            $data['faculty']='Факультет: ('.$f->name.") ".$f->full_name;

            $cobj=Cathedra::getCathedraObj($direction->cathedra);
            $data['cathedra']='Кафедра: ('.$cobj->name.") ".$cobj->full_name;
            $data['direction']=$direction->name." ".$direction->description;

        }
        setcookie("servstart",$confirm,time()+3600,"/");
        setcookie("idst",$_SESSION['user_id'],time()+3600,"/");

            } else {
        setcookie("servstart",0,time()+3600,"/");
        setcookie("idst",$_SESSION['user_id'],time()+3600,"/");
    }
        $student=Student::getStudentById($user);//информация о студенте
    $data['stname']=$student->getFio();
    $data['avg_point']=4.63;
    $data['year']=date('Y');

    echo json_encode($data);
}
