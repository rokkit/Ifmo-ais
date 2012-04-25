<?php
require '../../auth.php';
require_once '../../function.php';
require_once '../../Student/Student.php';
require '../../../php_script/djpate-docxgen/phpDocx.php';

if(isset($_GET['id'])) {//формируем документ
    $fspodb = connectToFspoDB();
    $student=Student::getStudentById($_GET['id']);
    $phpdocx="";
    try {
        $template="template_form.docx";
        $phpdocx = new phpdocx($template);
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
    if ($phpdocx) {
        //Записываем информацию о студенте
        $phpdocx->assignBlock("student",array(array("#FIO#"=>$student->getFio())));

    $phpdocx->assign("#ID#", $_GET['id']);
    $phpdocx->download();
    }

}
?>
