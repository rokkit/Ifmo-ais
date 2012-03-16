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
    static function connectToFspoDB()
    {
        $dbhost="localhost";
        $dbname="ifmodb";
        $dbuser="root";
        $dbpass="1405";
        $fspodb=mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
        mysql_select_db($dbname,$fspodb);
        mysql_query("set names utf8") or die('UTF8 ERROR');
        return $fspodb;
    }
    
    public function getFio()
    {
        return $this->last_name." ".$this->name." ".$this->second_name;
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
    static function getStudents($params)
    {

        if (isset($_POST['sortorder'])) {
        $sortorder = mysql_real_escape_string($_POST['sortorder']);
        }
        $sql="SELECT Stud_ID, Ima, Familia, Otchestvo, gruppa, programm FROM stud_table";
        $sortSql = " order by Familia $sortorder";
        $data = array();
        $data['rows'] = array();
        $data['total'] = null;
        $fspodb=Student::connectToFspoDB();
        
        if($params['params']=='all')//все студенты. без фильтра
        {                      

            
        }
        if($params['group']!=null)//фильтр по группе
        {
            $group = parseNumSql($params['group']);
            $sql.=" WHERE gruppa=$group";
        }
        if($params['params']=='choosed_direction')//только с выбранным направлением
        {
            include '../dbconnect.php';
            $result = mysql_query("SELECT id_student,id_direction,id_cathedra,form_education FROM student_choose WHERE confirm=1", $ifmodb) or die(mysql_error($ifmodb));//получаем выбранные ид
            while($student_id = mysql_fetch_array($result))
            {
                $choosed_sql=(isset($params['group'])) ? " AND Stud_ID=$student_id[0]" : " WHERE Stud_ID=$student_id[0]";
                $t_sql=$sql;
                $t_sql.=$choosed_sql;
                
                $result_choosed_students = mysql_query($t_sql.$sortSql, $fspodb) or die(mysql_error($fspodb));
                if($result_choosed_student = mysql_fetch_array($result_choosed_students))
                {
                    $programm = ($student['programm']==0) ? "Непрерывная" : "Базовая";
                    $fio=$result_choosed_student['Familia']." ".$result_choosed_student['Ima']." ".$result_choosed_student['Otchestvo'];
                    $link_to_student="<a href=/php_script/Student/get_student.php?id=".$result_choosed_student['Stud_ID'].">$fio</a>";
                    $data['rows'][] = array('id' => $result_choosed_student['Stud_ID'],
                                        'cell' => array($link_to_student,$result_choosed_student['gruppa'],$programm) );
                }    
            }
            echo json_encode($data);
            return;
         }
            
            $result =  mysql_query($sql.$sortSql,$fspodb) or die(mysql_error());
            while($student = mysql_fetch_array($result))
            {
                $programm = ($student['programm']==1) ? "Непрерывная" : "Базовая";
                $fio=$student['Familia']." ".$student['Ima']." ".$student['Otchestvo'];
                $link_to_student="<a href=/php_script/Student/get_student.php?id=".$student['Stud_ID'].">$fio</a>";
                $data['rows'][] = array('id' => $student['Stud_ID'],
                                        'cell' => array($link_to_student,$student['gruppa'],$programm) );
            }
        // Return JSON data
        echo json_encode($data);
    }
}

?>
