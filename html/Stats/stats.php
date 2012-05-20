<?php require '../../php_script/auth.php'; ?>
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

