<?php

$root = $_SERVER['DOCUMENT_ROOT'];
require '../../auth.php';
require_once '../../function.php';
require_once '../../Student/Student.php';
require '../../../php_script/djpate-docxgen/phpDocx.php';
//require '../../../php_script/includes/ZipArchive.php';
require_once "../../djpate-docxgen/lib/pclzip.lib.php";

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
                $files=array();
                $directory="files/";
                $zipdir="files/archives/";
                foreach($ids as $id) {
                    $id = parseNumSql($id);
                    $student=Student::getStudentById($id);
        $phpdocx->assignBlock("block",array(array("#GROUP#"=>$student->group,
                                                  "#PERIOD#"=>"1.05.2003",
                                                  "#SPECIALITION#"=>"230105",
                                                  "#FIO#"=>$student->getFio())));
        $phpdocx->assignTable("points",array(array("№","Дисциплина","Объём работы студ.","Форма итог. контр.","Оценка","Состав аттестационной комиссии"),
                                             array(1,2,3,4,5,6)));
        $filename = $directory.encodestring($student->name."_".$student->last_name)."_".$student->group.".docx";

        @$phpdocx->save($filename);//тут вылезают ошибки на денаид но они никак не влияют
        $files[]=$filename;
                }
                $valid_files = array();
                /* for every file */
                foreach($files as $file) {
                /* if the file exists */
                    if(file_exists($file)) {
                    /* add it to our good file list */
                    $valid_files[] = $file;
                    }
                }
                if(count($valid_files)) {
                    $zipfilename=time().".zip";
                    $path = $zipdir.$zipfilename;

//                    $zip = new ZipArchive();
//                    if($zip->open($path, ZIPARCHIVE::CREATE)!==true)
//                            return false;
                        $zip=new PclZip($path);



                /* add files */
                foreach($valid_files as $file) {
                    $zip->add($file);
                }

                if(!file_exists($path)) {  return false; }
 /* force download zip */
    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');  }
    header('Pragma: public');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($path)).' GMT');
    header('Cache-Control: private',false);
    header('Content-Type: application/zip');
    header('Content-Disposition: attachment; filename="package.zip"');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: '.filesize($path));
    header('Connection: close');
    readfile($path);
    exit();
                }
            }
        }
    }


?>
