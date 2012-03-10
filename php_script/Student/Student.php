<?php
/**
 * Description of Student
 *
 * @author rokkitlanchaz
 */
class Student {
    
    public $id;//Ид
    public $name;//Имя
    public $last_name;//Фамилия
    public $second_name;//Отчество
    public $group;//Группа
    public $programm;//Непрерывная или базовая
    
    function __construct($id,$name,$last_name,$second_name,$group,$programm) 
    {
        $this->id=$id;
        $this->name=$name;
        $this->last_name=$last_name;
        $this->second_name=$second_name;
        $this->group=$group;
        $this->programm=$programm;
    }
    
    
    static function getStudentById($id_student)
    {
        $sql="SELECT Ima, Familia, Otchestvo, gruppa, programm FROM stud_table WHERE Stud_ID=$id_student";
        $students =  mysql_query($sql) or die (mysql_error());
        if($st =  mysql_fetch_array($students))
        {
            $student=new Student($id_student,$st['Ima'],$st['Familia'],$st['Otchestvo'],$st['gruppa'],$st['programm']);
        }
        return $student;
    }
}

?>
