<?php
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
require_once FNPATH.'function.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Статистика</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap.css">
        <link type="text/css" rel="stylesheet" href="/content/css/bootstrap-responsive.min.css">
        <link type="text/css" rel="stylesheet" href="/content/css/main.css">
        <link type="text/css" rel="stylesheet" href="/content/flexigrid.css">
        <link type="text/css" rel="stylesheet" href="/content/css/tufte-graph.css">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="/content/js/bootstrap-dropdown.js"></script>
        <script type="text/javascript" src="/content/js/flexigrid.pack.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
        <script type="text/javascript" src="/content/js/raphael-min.js"></script>
        <script type="text/javascript" src="/content/js/student-function.js"></script>
        <script type="text/javascript" src="/content/js/TufteGraph/jquery.enumerable.js"></script>
        <script type="text/javascript" src="/content/js/TufteGraph/jquery.tufte-graph.js"></script>
    </head>
    <body>
        <?php include ('../header-menu.php'); ?>
        <!-- end header menu -->
        <!-- main content -->
        <div class="container">
            <div class="span12" id="content">
                <h1>Статистика</h1>
                <div class="row row-content">
                    <div class="container-fluid">
                        <div class="row-fluid">
                            <div class="span3">
                            <ul class="nav nav-list">
                                <li>
                                    <a href="/php_script/Stats/graphics.php" data-pjax="#fcd-content">Графики</a>
                                </li>
                            </ul>
                        </div>
                        <div class="span6">
                            <div id="fcd-content">
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
                                                $.get("/php_script/Stats/hours_chart.php",{"discipline":discipline,"fspo":true},function(check_line){
                                                    $("#holder-hours-chart").tufteBar({
                                                        data:json,
                                                        barWidth: 0.8,
                                                        check_line: check_line,
                                                        axisLabel: function(index) { return this[1].label }
                                                    });
                                                })

                                            })
                                        });
                                    });
                                </script>

                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function() {
                $('a[data-pjax]').pjax();
            });
        </script>

    </body>
</html>

