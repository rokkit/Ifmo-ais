<div class="navbar">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="#">
                ИТМО
            </a>
            <ul class="nav">
                <li class="active">
                    <a href="/html/Student/main.php" data-pjax="#content"><i class="icon-white icon-home"></i> Домой</a>
                </li>
                <li>
                    <a href="/html/Student/main/struct.php" data-pjax="#content">Структура бакалавриата</a>
                </li>
                <li>
                    <a href="/html/Student/main/stats.php" data-pjax="#content">Статистика</a>
                </li>
                <li class="divider-vertical"></li>
            </ul>
            <ul class="nav pull-right">
                <li class="divider-vertical"></li>
                <li>
                <a class="st-name"><?php echo $_COOKIE['st-name'] ?></a>
                </li>
                <li class="divider-vertical"></li>
                <li>
                    <a href="<?='http://'.$_SERVER['HTTP_HOST'].'?action=logout'?>"><i class="icon-eject"></i> Выход</a>
                </li>
            </ul>
        </div>
    </div>
</div>
    <script>
        $(function(){
            $.hash = '#!/';
            $.siteurl = '<?php echo $_SERVER['HTTP_HOST']; ?>';
            $.container = '#container';
            $("a[data-pjax]").pjax();
        });
        $(function(){
            $(".nav li").click(
                function() {
                    $("li.active").removeClass("active");
                    $(this).addClass("active");
                }
            );
        });
    </script>
