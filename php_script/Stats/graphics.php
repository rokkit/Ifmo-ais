<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
require_once FNPATH.'function.php';
if(isset($_SERVER['HTTP_X_PJAX']))
{
?>
<title>Графики</title>
<div>
    <div class="row-fluid">
        <div class="span6">
            <h3>Популярность направлений</h3>
            <div id="holder-web-chart"></div>

        </div>
    </div>
        <div class="row-fluid">
            <hr>
            <div class="span6">
                <h3 style="margin-bottom: 30px;">Анализ соответствия дисциплин</h3>
                <div id="holder-hours-chart" style="height: 200px;">

                </div>

            </div>
                <div class="span4 chart-filter">
                    <label for="discipline">
                        Дисциплина
                    </label>
                    <select id="discipline">
                        <option>Пусто</option>
                        <?php $result = mysql_query("SELECT distinct name FROM discipline",  connectToIfmoDb()) or die(mysql_error());
                              while($temp = mysql_fetch_array($result)) {
                                echo "<option value='".$temp[0]."'>$temp[0]</option>";
                              }
                              mysql_close();
                        ?>
                    </select>
                </div>

        </div>
</div>
<script>
    $(function(){
        $.getJSON("/php_script/StudentService/get_stats.php", {}, function(json){
            drawWebChart(150,2,json,{"stroke-width": 0.8},
                                    {stroke:"05C","stroke-width": 2});
        })
    })
    //hours chart
    $(function() {
        $("#discipline").change(function() {


        var discipline=$("#discipline").val();
        $.getJSON("/php_script/Stats/hours_chart.php", {"discipline":discipline}, function(json) {
                    $("#holder-hours-chart").tufteBar({
                    data:json,
                    barWidth: 0.8
                    });
                })
        });
     });
</script>
<?php
}
?>

