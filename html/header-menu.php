<?php ?>
<div class="navbar">
            <div class="navbar-inner">
                <div class="container">
                    <a class="brand" href="#">
                        ИТМО
                    </a>
                <ul class="nav">
                    <li class="active">
                        <a href="/main.php"><i class="icon-home icon-white"></i>Домой</a>
                    </li>
                    <li>
                        <a href="/html/Forms/form_maker.php">Формирование документов</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Действия
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" id="action-drop">
                            <li><a id="data_edit_link" href="/html/data_editor.php">Структура бакалавриата</a></li>
                            <li><a id="trans_edit_link" href="/html/Trans/trans_editor.php">Соответствия дисциплин</a></li>
                            <li><a href="/html/Stats/stats.php">Статистика</a></li>
                        </ul>
                    </li>
                    <li class="divider-vertical pull-right"></li>
                    <ul class="nav pull-right">
                        <li class="divider-vertical"></li>
                        <li>
                            <a href="<?='http://'.$_SERVER['HTTP_HOST'].'?action=logout'?>"><i class="icon-eject"></i> Выход</a>
                        </li>
                    </ul>
                </ul>
                </div>
            </div>
        </div>
<?php ?>
