<?php
require '../../auth.php';
include '../../function.php';
require '../../djpate-docxgen/phpDocx.php';
if(isset($_GET['id'])) {//формируем документ
    $phpdocx="";
    try {
        $template="template_form.docx";
        $phpdocx = new phpdocx($template);
    } catch (Exception $exc) {
        echo $exc->getTraceAsString();
    }
    $phpdocx->assign("#ID#", $_GET['id']);
    $phpdocx->download();

    
}
?>
