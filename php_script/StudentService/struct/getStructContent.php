<?php
session_start();
/**
 * Created by JetBrains PhpStorm.
 * User: rokkitlanchaz
 * Date: 25.05.12
 * Time: 11:52
 * To change this template use File | Settings | File Templates.
 */
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");

require FNPATH.'function.php';
require FNPATH.'Struct/Faculty.php';
require FNPATH.'Struct/Cathedra.php';
require FNPATH.'Struct/Direction.php';

//if(json_requested()) {
    $data=array();
    $data['faculty_list']=array();
    //отдаём список факультетов
    $linkfm=connectToIfmo();
    if($result=$linkfm->query("SELECT id,name,full_name FROM faculty")) {
        while($faculty=$result->fetch_assoc()) {
            $data['faculty_list'][]=array('id'=>$faculty['id'],'name'=>$faculty['name']." ".$faculty['full_name']);
        }
    }
    if(!empty($_GET['faculty'])) {
       $f=Faculty::getFacultyObj($_GET['faculty']);
       $data['faculty']=array();
       $data['faculty'][]=array("name"=>'('.$f->name.") ".$f->full_name,
                                "dekan"=>$f->dekan,
                                "desc"=>$f->description);
    }
    if(!empty($_GET['cathedra'])) {
        $c=Cathedra::getCathedraObj($_GET['cathedra']);
        $data['cathedra']=array();
        $data['cathedra']=array("name"=>'('.$c->name.") ".$c->full_name,
                                "zavcath"=>$c->dekan,
                                "desc"=>$c->description,
                                "site"=>$c->site);
    }
    if(!empty($_GET['direction'])) {
        $d=Direction::getDirectionObj($_GET['direction']);
        $data['direction']=array();
        $data['direction']=array("name"=>$d->full_name,
                                 "price"=>$d->price);
    }
        echo json_encode($data);
//}
