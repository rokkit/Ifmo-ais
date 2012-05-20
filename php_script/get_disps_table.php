<script type="text/javascript" src="../content/js/bootstrap-modal.js"></script>
<script type="text/javascript">
var urlParams = <?php echo json_encode($_GET);?>;
    function doCommand(com, grid) {
            if (com == 'Изменить') {
            $('.trSelected', grid).each(function() {
            var id = $(this).attr('id');
            id = id.substring(id.lastIndexOf('row')+3);
            $("#ModalEditDisp").modal('show');
                        $.get("../php_script/set_disps.php",{id:id,get_update:"true"},
                            function(data)
                            {
                                data=JSON.parse(data);

                                for(i=1;i<data.length;i++)
                                {
                                    for(key in data[i])
                                    {
                                    //if([key]=="")
                                    $("#ModalEditDisp #set_"+[key]).val(data[i][key]);
                                    }
                                }
                            });

            });
            } else if (com == 'Удалить') {
                    $('.trSelected', grid).each(function() {
                    var id = $(this).attr('id');
                    id = id.substring(id.lastIndexOf('row')+3);

                    $.get("../php_script/set_disps.php", {id:id,get_delete:"true"}, function(data){
                        $("form#modal-delete").html(data);
                    });
                    $("#ModalDelDisp").modal('show');
                    });
                    }
                     else if (com == 'Добавить')
                    {
                    $("#ModalAddDisp").modal();
                    }

            }
            //вешаем на закрытие модала очистку внутри него
            $(function(){
            $("div#ModalDelDisp").on('hidden',function(){$("form#modal-delete").empty();})
            });

    $(function(){
       $("div#disp-table").flexigrid({
           url:'../php_script/get_disps.php?direction='+urlParams['direction'],
           dataType: 'json',
           colModel : [
                        {display: 'ID', name : 'id', width : 40, sortable : true, align: 'left'},
                        {display: 'Дисциплина', name : 'name', width : 150, sortable : true, align: 'left'},
                        {display: 'Семестр', name : 'semester', width : 70, sortable : true, align: 'left'},
                        {display: 'Кол-во часов', name : 'hours', width : 70, sortable : true, align: 'left'},
                        {display: 'Ауд. часы', name : 'aud_hours', width : 54, sortable : true, align: 'left'},
                        {display: 'Итог', name : 'type', width : 40, sortable : true, align: 'left'},
                        {display: 'Кафедра', name : 'main_cathedra', width : 60, sortable : true, align: 'left'},
           ],
           buttons : [
                        {name: 'Добавить', bclass: 'create', onpress : doCommand},
                        {name: 'Изменить', bclass: 'edit', onpress : doCommand},
                        {name: 'Удалить', bclass: 'delete', onpress : doCommand},
                        {separator: true}
                ],
           searchitems : [
                        {display: 'Дисциплина', name : 'name'}
                ],
                sortname: "name",
                sortorder: "asc",
                usepager: true,
                title: "Дисциплины",
                useRp: false,
                rp: 300,
                showToggleBtn:false,
                showTableToggleBtn: false,
                resizable: false,
                width: 700,
                height: 370,
                singleSelect: true
       });
    });

    //вешаем на сохранить сохранение
    $(function(){
        $("#save-changes").click(function(){
            var form=$("#add_disp_form").serialize();
            $.post("../php_script/set_disps.php", form, function(data){});
            $('#ModalAddDisp').modal('hide')
        });
        $("#save-changes-upd").click(function(){
            var form=$("#edit_disp_form").serialize();
            $.post("../php_script/set_disps.php", form, function(data){});
            $('#ModalEditDisp').modal('hide')
        });
    });
</script>

<div id="disp-table">

</div>

<div id="ModalAddDisp" class="modal hide fade">
    <form id="add_disp_form">
            <fieldset>
    <div class="modal-header">
        <h3>Добавление дициплины</h3>
    </div>
    <div class="modal-body">
        <table class="modal-table">
            <tr><td colspan="2"><label for="set_name">Дисциплина</label>
                <input type="text" style="width: 325px" name="set_name" id="set_name"/></td></tr>
                <tr><td><label for="set_semester">Семестр</label>
                <select id="set_semester" style="width: 50px" name="set_semester" class="span1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select></td>
                <td><label for="set_type">Итог</label>
                <select id="set_type" style="width: 120px" name="set_type" class="span2">
                    <option value="0">Экзамен</option>
                    <option value="1">Зачёт</option>
                    <option value="2">Зачёт/Экзамен</option>
                </select></td></tr>
                <tr><td><label for="set_hours" >Количество часов</label>
                <input type="text" style="width: 50px" name="set_hours" class="span1" id="set_hours"/></td>
                <td><label for="set_aud_hours">Аудиторные часы</label>
                <input type="text" style="width: 50px" name="set_aud_hours" class="span1" id="set_aud_hours"/></td></tr>
                <tr><td><label for="set_point">Зачётные единицы</label>
                <input type="text" style="width: 50px" name="set_point" class="span1" id="set_point"/></td>
                <td><label for="set_main_cathedra">Ведущая кафедра</label>
                <select id="set_main_cathedra" style="width: 120px" name="set_main_cathedra" class="span2">
                    <?php
require 'dbconnect.php';

                $cats =  mysql_query("SELECT id,name FROM cathedra");
                while($cat =  mysql_fetch_array($cats))
                {
                    echo "<option value=".$cat['id'].">".$cat['name']."</option>";
                }
                    ?>
                </select></td></tr>
                <input type="hidden" name="create-disp" value="true"/>
                <input type="hidden" name="set_direction" id="set_direction" value=""/>
                <script>
                $(function(){
                    var dir=$("select#direction").val();
                    $("input#set_direction").val(dir);
                });
                </script>
        </table>
    </div>
    <div class="modal-footer">
        <a href="#" id="save-changes" class="btn btn-primary">Save changes</a>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
                </fieldset>
              </form>
</div>

<div id="ModalEditDisp" class="modal hide">
    <form id="edit_disp_form">
            <fieldset>
    <div class="modal-header">
        <h3>Изменение дициплины</h3>
    </div>
    <div class="modal-body">
            <table class="modal-table">
                <tr><td colspan="2"><label for="set_name">Дисциплина</label>
                <input type="text" style="width: 325px" name="set_name" id="set_name"/></td></tr>
                <tr><td><label for="set_semester">Семестр</label>
                <select style="width: 50px" id="set_semester" name="set_semester" class="span1">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select></td>
                <td><label for="set_type">Итог</label>
                <select style="width: 120px" id="set_type" name="set_type" class="span2">
                    <option value="0">Экзамен</option>
                    <option value="1">Зачёт</option>
                    <option value="2">Зачёт/Экзамен</option>
                </select></td></tr>
                <tr><td><label for="set_hours" >Количество часов</label>
                <input type="text" name="set_hours" class="span1" style="width: 50px" id="set_hours"/></td>
                <td><label for="set_aud_hours">Аудиторные часы</label>
                <input type="text" name="set_aud_hours" class="span1"style="width: 50px" id="set_aud_hours"/></td></tr>
                <tr><td><label for="set_point">Зачётные единицы</label>
                <input type="text" name="set_point" class="span1" style="width: 50px" id="set_point"/></td>
                <td><label for="set_main_cathedra">Ведущая кафедра</label>
                <select id="set_main_cathedra" name="set_main_cathedra" style="width: 120px" class="span2">
                    <?php
$dbhost="localhost";
$dbname="ifmodb";
$dbuser="root";
$dbpass="1405";
mysql_connect($dbhost,$dbuser,$dbpass) or die("connect error");
mysql_select_db($dbname) or die("select error");
mysql_query("set names utf8") or die('UTF8 ERROR');

                $cats =  mysql_query("SELECT id,name FROM cathedra");
                while($cat =  mysql_fetch_array($cats))
                {
                    echo "<option value=".$cat['id'].">".$cat['name']."</option>";
                }
                    ?>
                </select></td></tr>
            </table>
                <input type="hidden" name="update-disp" value="true"/>
                <input type="hidden" name="set_id" id="set_id"/>
                <input type="hidden" name="set_direction" id="set_direction" value=""/>
                <script>
                $(function(){
                    var dir=$("select#direction").val();
                    $("input#set_direction").val(dir);
                });
                </script>
    </div>
    <div class="modal-footer">
        <a href="#" id="save-changes-upd" class="btn btn-primary">Save changes</a>
        <a href="#" class="btn" data-dismiss="modal">Close</a>
    </div>
                </fieldset>
              </form>
</div>

<div id="ModalDelDisp" class="modal hide">
    <div class="modal-header">
        <h3>Удаление дисциплины</h3>
    </div>
    <form id="modal-delete">

    </form>
</div>
<script>
    //валидация формы

    $(function() {


    $("#add_disp_form").validate({
        rules: {
            set_name:"required",
            set_hours: {
                required:true,
                number:true
            },
            set_aud_hours: {
                required:true,
                number:true
            },
            set_semester: {
                required:true,
                number:true
            },
            set_point: {
                required:true,
                number:true
            }
        },
        messages: {
            set_name: "Введите название",
            set_hours: {
                required: "Введите кол-во часов",
                number: "Введите число"
            },
            set_aud_hours: {
                required:"Введите ауд. часы",
                number: "Введите число"
            },
            set_semester: {
                required:"Введите семестр",
                number: "Введите число"
            },
            set_point: {
                required:"Введите зачетные единицы",
                number: "Введите число"
            }
        }
    });
        $("#edit_disp_form").validate({
        rules: {
            set_name:"required",
            set_hours: {
                required:true,
                number:true
            },
            set_aud_hours: {
                required:true,
                number:true
            },
            set_semester: {
                required:true,
                number:true
            },
            set_point: {
                required:true,
                number:true
            }
        },
        messages: {
            set_name: "Введите название",
            set_hours: {
                required: "Введите кол-во часов",
                number: "Введите число"
            },
            set_aud_hours: {
                required:"Введите ауд. часы",
                number: "Введите число"
            },
            set_semester: {
                required:"Введите семестр",
                number: "Введите число"
            },
            set_point: {
                required:"Введите зачетные единицы",
                number: "Введите число"
            }
        }
    });

    })
</script>
