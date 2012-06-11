<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="/content/js/jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="/content/js/jquery.pjax.js"></script>
        <script type="text/javascript" src="/content/js/jquery.chainedSelects.js"></script>
        <script type="text/javascript" src="/content/js/jquery.cookie.js"></script>
        <script type="text/javascript" src="/content/js/raphael-min.js"></script>
        <script type="text/javascript" src="/content/js/student-function.js"></script>
    </head>
    <body>
        <div id="web-chart-content" class="span9 truewell chart-content" style="height: 450px; display: none;">
            <h2>Диаграмма</h2>
            <div id="holder-web-chart"  style="height: 200px;">

            </div>
            <script>
            $(function(){$.getJSON("/php_script/StudentService/get_stats.php", {type:"ch",graph:"web"}, function(json){
            drawWebChart("holder-web-chart",150,2,json,{"stroke-width": 0.8},
            {stroke:"05C","stroke-width": 2});
            });
            });
            </script>
        </div>
    </body>
</html>
