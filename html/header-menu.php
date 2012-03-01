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
                        <a href="/html/form_maker.php">Формирование выписок</a>
                    </li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            Действия
                            <b class="caret"></b>
                        </a>
                        <ul class="dropdown-menu" id="action-drop">
                            <li><a id="trans_edit_link" href="/html/Trans/trans_editor.php">Изменение переходов</a></li>
                            <li><a id="data_edit_link" href="/html/data_editor.php">Изменение данных</a></li>
                            <li><a href="#">Статистика</a></li>
                        </ul>
                    </li>    
                </ul>
                </div>
            </div>
        </div>
<?php ?> 