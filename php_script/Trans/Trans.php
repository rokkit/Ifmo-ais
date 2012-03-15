<?php


/**
 * Description of Trans
 *
 * @author rokkitlanchaz
 */
class Trans {
    public $id;//ид перехода
    public $discipline;//ид дисциплины
    public $subject;//ид предмета. база фспо
    public $direction;//если ноль, то глобально для всех направлений
    
    function __construct($id,$discipline,$subject,$direction) {
        $this->id=$id;
        $this->discipline=$discipline;
        $this->subject=$subject;
        $this->direction=$direction;
    }
    static function getTransfersByIdDirection($direction)//получить переходы согласно выбранному направлению и студенту
    {
        $direction = parseNumSql($direction);
        if(!$direction) return;
        $sql="SELECT * FROM transfer WHERE id_direction IS NULL OR id_direction=$direction";
        $result = mysql_query($sql) or die(mysql_error());// получаем переходы
        $transfers=array();
        while ($row = mysql_fetch_array($result)) 
        {
            $transfers[]=new Trans($row['id'], $row['id_discipline'], $row['id_subject'], $row['id_direction']);
        }
        return $transfers;//возвращаем массив переходов
    }
    static function getStudentChooseByIdStudent($student,$ifmodb)
    {
        $student = parseNumSql($student);
        $result =  mysql_query("SELECT id_direction, id_cathedra FROM student_choose WHERE id_student=$student",$ifmodb);
        $choose=array();
        if($choose = mysql_fetch_assoc($result))
        {
          ////выбор студента
        $result = mysql_query("SELECT name, full_name FROM cathedra WHERE id=".$choose["id_cathedra"],$ifmodb) or die(mysql_error());
        $result= mysql_fetch_assoc($result);
        $choose['name_cathedra']=$result['name'];//записываем в выбор название кафедры
        $choose['full_name_cathedra']=$result['full_name'];//записываем в выбор полное название кафедры
        
        $result = mysql_query("SELECT name, description FROM direction WHERE id=".$choose["id_direction"],$ifmodb) or die(mysql_error());
        $result= mysql_fetch_assoc($result);
        $choose['name_direction'] = $result['name'];//записываем в выбор название направления
        $choose['full_name_direction'] = $result['description'];//записываем в выбор полное навзвание напрвления
        
        return $choose;
        }
        else return null;
        
        
    }
    static function getSubjectById($subject,$fspodb)
    {
        $subject = parseNumSql($subject);
        $result = mysql_query("SELECT Name FROM predmeti_table WHERE Predmet_ID=$subject", $fspodb) or die(mysql_error());
        echo mysql_result($result, 0);
    }
    static function getDisciplineById($discipline,$ifmodb)
    {
        $discipline = parseNumSql($discipline);
        $result = mysql_query("SELECT name FROM discipline WHERE id=$discipline", $ifmodb) or die(mysql_error());
        echo mysql_result($result, 0);
    }
    static function getSubjectByDiscipline($discipline,$fspodb,$ifmodb)//получить предмет соотвествущий дисциплине
    {
        $discipline = parseNumSql($discipline);
        if($discipline) 
        {
        $result = mysql_query("SELECT id_subject FROM transfer WHERE id_discipline=$discipline",$ifmodb) or die(mysql_error());
            if($subject = @mysql_result($result, 0))
            {
                //получаем имя предмета и вовзращаем его
                $result = mysql_query("SELECT Name FROM predmeti_table WHERE Predmet_ID=$subject",$fspodb)or die(mysql_error());
                return mysql_result($result, 0);
            }
            else {return "Пусто";}
        }
        
    }
    static function getDisciplinesByDirection($direction,$ifmodb)//получить набор дисциплин для направления
    {
        $direction = parseNumSql($direction);
        $result = mysql_query("SELECT id, name FROM discipline WHERE id_direction = $direction",$ifmodb) or die(mysql_error());
        $disciplines = array();
        while($row = mysql_fetch_array($result))
        {
            $disciplines[] = $row[0];
        }
        return $disciplines;
    }
    
}

?>
