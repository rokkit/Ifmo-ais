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
class Faculty {
    public $id;
    public $name;
    public $full_name;
    public $dekan;
    public $description;

    function __construct($id,$name,$full_name,$dekan,$description)
    {
        $this->id=$id;
        $this->name=$name;
        $this->full_name=$full_name;
        $this->dekan=$dekan;
        $this->description=$description;
    }

    static function getFaculty($id=null)
    {
        $query="SELECT * FROM FACULTY";
        $id=  parseNumSql($id);
        if(!empty($id))
        {

            $query.=" WHERE id=$id";
        }
        $data=array();
        $results =  mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
        while($result =  mysql_fetch_array($results))
        {
            $data[]=new Faculty($result['id'], $result['name'], $result['full_name'], $result['dekan'], $result['description']);
        }
        return json_encode($data);
    }
    static function getFacultyObj($id)
    {
        $query="SELECT * FROM FACULTY";
        $id=  parseNumSql($id);
        if(!empty($id))
        {

            $query.=" WHERE id=$id";
        }
        $data=null;
        $result =  mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
        if($result =  mysql_fetch_array($result))
        {
            $data=new Faculty($result['id'], $result['name'], $result['full_name'], $result['dekan'], $result['description']);
        }
        return $data;
    }
    static function getName($faculty){
        $id =  parseNumSql($faculty);
        $name=mysql_query("SELECT name FROM faculty WHERE id=$id",connectToIfmoDb()) or die(mysql_error());
        return $name = mysql_result($name, 0);
    }

}

?>
