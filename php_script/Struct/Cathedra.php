<?php
//include_once '../../php_script/function.php';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Faculty
 *
 * @author rokkitlanchaz
 */
class Cathedra {
    public $id;
    public $name;
    public $full_name;
    public $dekan;
    public $description;
    public $site;

    function __construct($id,$name,$full_name,$dekan,$description,$site=null)
    {
        $this->id=$id;
        $this->name=$name;
        $this->full_name=$full_name;
        $this->dekan=$dekan;
        $this->description=$description;
        $this->site=$site;
    }
    static function getCathedraObj($id)
    {
        $query="SELECT * FROM cathedra";
        $id =  parseNumSql($id);
          $query.=" WHERE id=$id";
        $data=null;
        $results =  mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
        if($result =  mysql_fetch_array($results))
        {
            $data=new Cathedra($result['id'], $result['name'], $result['full_name'], $result['dekan'], $result['description'],$result['site']);
        }
        return $data;
    }
    static function getCathedra($faculty=null)
    {
        $query="SELECT * FROM cathedra";
        $id =  parseNumSql($faculty);
        if(!empty($id))
        {

            $query.=" WHERE id_faculty=$id";
        }
        $data=array();
        $results =  mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
        while($result =  mysql_fetch_array($results))
        {
            $data[]=new Cathedra($result['id'], $result['name'], $result['full_name'], $result['dekan'], $result['description']);
        }
        return json_encode($data);
    }
    static function getName($cathedra)
    {
        $id =  parseNumSql($cathedra);
        $name=mysql_query("SELECT name FROM cathedra WHERE id=$id",connectToIfmoDb()) or die(mysql_error());
        return $name = mysql_result($name, 0);
    }
    static function getZav($cathedra) {
        $id =  parseNumSql($cathedra);
        $zav=mysql_query("SELECT dekan FROM cathedra WHERE id=$id",connectToIfmoDb()) or die(mysql_error());
        return $zav=mysql_result($zav,0);
    }
}
?>
