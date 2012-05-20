<?php

$root = $_SERVER['DOCUMENT_ROOT'];
define('SCRIPTPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require '../../auth.php';
require_once SCRIPTPATH.'/function.php';
require_once '../../Student/Student.php';
require '../../../php_script/djpate-docxgen/phpDocx.php';
require_once "../../djpate-docxgen/lib/pclzip.lib.php";
require_once SCRIPTPATH.'Struct/Cathedra.php';
require_once SCRIPTPATH.'Struct/Direction.php';
require_once SCRIPTPATH.'Struct/Faculty.php';
function zipAndDownload($files) {
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

                        $zip=new PclZip($path);

                /* add files */
                foreach($valid_files as $file) {
                    $zip->add($file);
                }

                if(!file_exists($path)) {  return false; echo 'no'; }
 /* force download zip */
    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');  }

			header('Content-Description: File Transfer');
			header('Content-Type: application/zip');
			header('Content-Disposition: attachment; filename='.basename($path));
                        header('Content-Transfer-Encoding:binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($path)).' GMT');
                        header('Cache-Control: private',false);
			header('Pragma: public');
			header('Content-Length: ' . filesize($path));
                        $file = @fopen($path,"rb");
if ($file) {
  while(!feof($file)) {
    print(fread($file, 1024*8));
    flush();
    if (connection_status()!=0) {
      @fclose($file);
      die();
    }
  }
  @fclose($file);
}
}
}
if(isset($_REQUEST['id'])) {//формируем документ
    $fspodb = connectToFspoDB();
    $student=Student::getStudentById($_REQUEST['id']);
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
    @$phpdocx->download();
    }
  }
    if($_REQUEST['type']=="archive") {
        if($_REQUEST['form']=="form") {
            if(isset($_REQUEST['ids'])) {
                /* split the querystring */
                if($_REQUEST['ids']!="all") {
                $ids = rtrim($_REQUEST['ids'], ";");
                $ids = explode(";", $ids);
                }
                else if($_REQUEST['ids']=="all") {
                    $result=  mysql_query("SELECT id_student FROM student_choose WHERE confirm=1", connectToIfmoDb()) or die(mysql_error());
                    while($st = mysql_fetch_assoc($result)) {
                        $ids[] = $st['id_student'];
                    }
                }
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
                zipAndDownload($files);
//                $valid_files = array();
//                /* for every file */
//                foreach($files as $file) {
//                /* if the file exists */
//                    if(file_exists($file)) {
//                    /* add it to our good file list */
//                    $valid_files[] = $file;
//                    }
//                }
//                if(count($valid_files)) {
//                    $zipfilename=time().".zip";
//                    $path = $zipdir.$zipfilename;
//
//                        $zip=new PclZip($path);
//
//                /* add files */
//                foreach($valid_files as $file) {
//                    $zip->add($file);
//                }
//
//                if(!file_exists($path)) {  return false; echo 'no'; }
// /* force download zip */
//    if(ini_get('zlib.output_compression')) { ini_set('zlib.output_compression', 'Off');  }
//
//			header('Content-Description: File Transfer');
//			header('Content-Type: application/zip');
//			header('Content-Disposition: attachment; filename='.basename($path));
//                        header('Content-Transfer-Encoding:binary');
//			header('Expires: 0');
//			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
//                        header('Last-Modified: '.gmdate('D, d M Y H:i:s', filemtime($path)).' GMT');
//                        header('Cache-Control: private',false);
//			header('Pragma: public');
//			header('Content-Length: ' . filesize($path));
//                        $file = @fopen($path,"rb");
//if ($file) {
//  while(!feof($file)) {
//    print(fread($file, 1024*8));
//    flush();
//    if (connection_status()!=0) {
//      @fclose($file);
//      die();
//    }
//  }
//  @fclose($file);
//}

                //}
            }
        }
        else if($_REQUEST['form']=='extract') { //запрос выписки

                $ifmodb=connectToIfmoDb();
                /* split the querystring */
                if($_REQUEST['ids']!="all") {
                $ids = rtrim($_REQUEST['ids'], ";");
                $ids = explode(";", $ids);
                }
                else if($_REQUEST['ids']=="all") {
                    $result = mysql_query("SELECT id_student FROM student_choose WHERE confirm=1",$ifmodb ) or die(mysql_error());
                    while($st = mysql_fetch_assoc($result)) {
                        $ids[] = $st['id_student'];
                    }
                }
                //распределяем студентов по направлениям
                $students=array();
                foreach($ids as $id) {
                    $id = parseNumSql($id);
                    $result = mysql_query("SELECT id_direction FROM student_choose WHERE confirm=1 AND id_student=$id", $ifmodb) or die(mysql_error());
                    $students[$id] =  mysql_result($result, 0);
                }
                $dirs =  array_unique($students);//выбираем уникальные  направления
                $dirs = array_flip($dirs);
                $t_dirs = $dirs;

                foreach($dirs as $dir => $values) {
                    $t_dirs[$dir] = array_keys($students, $dir);
                }
                //массив вида направление => массив студентов
                $dirs=$t_dirs;
                unset($t_dirs);

                    /* формируем документ
                     * #DATE# => Дата составления
                     * #FACNAME# => Название факультета
                     * #FIODEKAN# => ФИО декана
                     * #FIODEKAN2# => ФИО декана в дательном падеже
                     * #STATUS# => Заведущей / Заведущему кафедры
                     * #ZAVCATHEDR# => ФИО завкафедры
                     * #CATHEDRA# => Название Кафедры
                     * #DIRECTION# => Направление
                     * #STUDENTS# => Список студентов
                    */
                $phpdocx="";
                try {
                    $template="extract_template.docx";
                    $phpdocx = new phpdocx($template);

                } catch (Exception $exc) {
                    echo $exc->getTraceAsString();
                }
                $files=array();
                foreach($dirs as $dir => $stds) {
                    $phpdocx->assign('#DATE#', date('d.m.Y'));
                    $direction = json_decode(Direction::getFullInfo($dir));
                    $faculty=Faculty::getFacultyObj($direction->faculty);
                    $cathedra = Cathedra::getCathedraObj($direction->cathedra);
                    $phpdocx->assign('#FACNAME#', $faculty->full_name);
                    $phpdocx->assign("#FIODEKAN#", $faculty->dekan);
                    $phpdocx->assign('#CATHEDRA#', $cathdra->name);
                    $phpdocx->assign('#ZAVCATHEDR#',$cathedra->dekan);
                    $phpdocx->assign('#DIRECTION#',$direction->name." ".$direction->description);
                    $arr = array(); //need array like array(array(name=>value))
                    foreach($stds as $std) {

                        $student=Student::getStudentById($std);
                        $arr[]=array('#FIO#'=>$student->getFio());
                    }
                    $phpdocx->assignBlock('students',$arr);

                    $file_name=$direction->name." ".date("d_m_Y").".docx";
                    @$phpdocx->save($file_name);
                    $files[]=$file_name;

                }
                zipAndDownload($files);
        }

    }


?>
