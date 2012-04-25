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
        $template="template_end_form.docx";
        $phpdocx = new phpdocx($template);
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
    if ($phpdocx) {
        //Записываем информацию о студенте
        $phpdocx->assignBlock("block",array(array("#GROUP#"=>"423",
                                                  "#PERIOD#"=>"1.05.2003",
                                                  "#SPECIALITION#"=>"230105",
                                                  "#FIO#"=>$student->getFio())));

    $phpdocx->assignTable("points",array(array("№","Дисциплина","Объём работы студ.","Форма итог. контр.","Оценка","Состав аттестационной комиссии"),array(1,2,3,4,5,6)));
    $phpdocx->download();
    }

}
?>
