<?php
session_start();
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require_once FNPATH.'auth.php';
?>
<script type="text/javascript" src="/content/js/raphael-min.js"></script>
<script type="text/javascript" src="/content/js/student-function.js"></script>
<title>Статистика</title>
<div class="container-fluid">
    <div class="row-fluid">
        <div class="span3 truewell">
            <div class="sidebar-nav">
                <ul class="nav nav-list">
                    <li class="nav-header">Sidebar</li>
                    <li class="active"><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li><a href="#">Link</a></li>
                    <li class="nav-header">Sidebar</li>
                </ul>
            </div>
        </div>
        <div class="span9 truewell">
            <h2>График популярности направлений подготовки</h2>

            <div class="span5" id="holder-web-chart">

            </div>
            <div class="span4">
                <h3>Направления подготовки</h3>
                <select>
                    <option>Пусто</option>
                </select>
                <a href="#">+</a>
            </div>
            <script>
                $(function(){
                    var ids=[];
                    $.getJSON("/php_script/StudentService/get_stats.php", {type:"ch",ids:ids}, function(json){
                        drawWebChart(150,2,json,{"stroke-width": 0.8},
                            {stroke:"05C","stroke-width": 2});
                    })
                })
            </script>
        </div>
    </div>
</div>