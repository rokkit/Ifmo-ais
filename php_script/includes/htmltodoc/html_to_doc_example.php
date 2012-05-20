<?php

	include("html_to_doc.inc.php");

	$htmltodoc= new HTML_TO_DOC();

	//$htmltodoc->createDoc("reference1.html","test");
	$htmltodoc->createDocFromURL("http://localhost:8080/newhtml1.html","test",true);
        //echo file_get_contents("http://google.com");


?>