<?php
$root = $_SERVER['DOCUMENT_ROOT'];
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
    if($_POST['type']=="archive") {
        if($_POST['form']=="form") {
            if(isset($_POST['ids'])) {
                /* split the querystring */
                $ids = rtrim($_POST['ids'], ";");
                $ids = explode(";", $ids);
                $phpdocx="";
                try {
                    $template="template_end_form.docx";
                    $phpdocx = new phpdocx($template);
                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }

                //creating documents
                foreach($ids as $id) {
                    $id = parseNumSql($id);
                    $student=Student::getStudentById($id);
        $phpdocx->assignBlock("block",array(array("#GROUP#"=>$student->group,
                                                  "#PERIOD#"=>"1.05.2003",
                                                  "#SPECIALITION#"=>"230105",
                                                  "#FIO#"=>$student->getFio())));
        $phpdocx->assignTable("points",array(array("№","Дисциплина","Объём работы студ.","Форма итог. контр.","Оценка","Состав аттестационной комиссии"),
                                             array(1,2,3,4,5,6)));
        $phpdocx->write($student->name.$student->last_name.$student->group);

                }
                $valid_files = array();
                /* for every image */
                foreach($file as $files) {
                /* if the image exists */
                    if(file_exists($file)) {
                    /* add it to our good file list */
                    $valid_files[] = $file;
                    }
                }
            }
        }
    }


?>
