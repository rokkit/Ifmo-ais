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

            $data['faculty']=Faculty::getName($direction->faculty);
            $data['cathedra']=Cathedra::getName($direction->cathedra);
            $data['direction']=$direction->name." ".$direction->description;

        }
        setcookie("servstart",$confirm,time()+3600,"/");
        setcookie("idst",$_SESSION['user_id'],time()+3600,"/");

        $student=Student::getStudentById($user);//информация о студенте
        $data['stname']=$student->getFio();

    } else {
        setcookie("servstart",0,time()+3600,"/");
        setcookie("idst",$_SESSION['user_id'],time()+3600,"/");
    }

    echo json_encode($data);
}