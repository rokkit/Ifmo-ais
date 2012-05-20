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
class Direction {
    public $id;
    public $name;
    public $full_name;
    public $description;
    public $cathedra;
    public $faculty;

    function __construct($id,$name,$full_name,$description)
    {
        $this->id=$id;
        $this->name=$name;
        $this->full_name=$full_name;
        $this->description=$description;
    }
    static function getDirection($cathedra=null)
    {
        $query="SELECT * FROM direction";
        $id =  parseNumSql($cathedra);
        if(!empty($id))
        {

            $query.=" WHERE id_cathedra=$id";
        }
        $data=array();
        $results =  mysql_query($query,  connectToIfmoDb()) or die(mysql_error());
        while($result =  mysql_fetch_array($results))
        {
            $data[]=new Direction($result['id'], $result['name'], $result['full_name'], $result['description']);
        }
        return json_encode($data);
    }
    static function getFullInfo($id)
    {
        $ifmodb = connectToIfmoDb();
        $linkfm=connectToIfmo();
        $id = parseNumSql($id);
        $result = mysql_query("SELECT * FROM direction WHERE id=$id",$ifmodb) or die(mysql_error());
        if($result=mysql_fetch_array($result)) {
            $direction=new Direction($result['id'], $result['name'], $result['full_name'], $result['description']);
        //теперь получаем инф о кафедре и факультете
        $direction->cathedra=$result['id_cathedra'];

        $faculty = mysql_query("SELECT id_faculty FROM cathedra WHERE id=$direction->cathedra",$ifmodb);
        $direction->faculty = mysql_result($faculty, 0);

        }
        return json_encode($direction);
    }
}
?>
