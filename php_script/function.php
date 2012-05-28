<?php
define("IFMO_DB_HOST","localhost");
define("IFMO_DB_USER","root");
define("IFMO_DB_PASS","1405");
define("IFMO_DB_NAME","ifmodb");

define("FSPO_DB_HOST","localhost");
define("FSPO_DB_USER","root");
define("FSPO_DB_PASS","1405");
define("FSPO_DB_NAME","ifmodb");
function connectToIfmo() {
    $mysqli = new mysqli(IFMO_DB_HOST,IFMO_DB_USER,IFMO_DB_PASS,IFMO_DB_NAME);
    $mysqli->set_charset("utf8");
    return $mysqli;
}
function connectToFspo() {
    return new mysqli(FSPO_DB_HOST,FSPO_DB_USER,FSPO_DB_PASS,FSPO_DB_NAME);
}
function parseNumSql($num)
{
    $num =  mysql_escape_string($num);
    if(preg_match("/^[0-9]+$/", $num))
    {
        return $num;
    }
    return null;
}
    function connectToFspoDB()
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
    function connectToIfmoDb()
    {
        $dbhost="localhost";
        $dbname="ifmodb";
        $dbuser="root";
        $dbpass="1405";
        $ifmodb=mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
        mysql_select_db($dbname,$ifmodb);
        mysql_query("set names utf8") or die('UTF8 ERROR');
        return $ifmodb;
    }

  // функция превода текста с кириллицы в траскрипт
  function encodestring($st)
  {
    // Сначала заменяем "односимвольные" фонемы.
    $st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_",
    "abvgdeeziyklmnoprstufh'iei");
    $st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_",
    "ABVGDEEZIYKLMNOPRSTUFH'IEI");
    // Затем - "многосимвольные".
    $st=strtr($st,
                    array(
                        "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh",
                        "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya",
                        "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH",
                        "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA",
                        "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye"
                        )
             );
    // Возвращаем результат.
    return $st;
  }
function json_requested() {
    return  isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
        $_SERVER['HTTP_X_REQUESTED_WITH']  == 'XMLHttpRequest' &&

        isset($_SERVER['HTTP_ACCEPT']) &&
        $_SERVER['HTTP_ACCEPT'] == 'application/json';
}

?>
