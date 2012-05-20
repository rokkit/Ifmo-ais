<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" media="screen" charset="utf-8"/>
<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" charset="utf-8"/>
<script src="js/jquery-1.7.2.min.js" type="text/javascript" language="javascript" charset="utf-8"></script>
</head>
<body>
    <div id="contact_table" class="well">
        <table class="table">
            <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Телефон</th>
                <th>Дата</th>
                <th><input id='search' type='text' class='span2'/></th>
            </tr>
            </thead>
            <tbody id="contact_list">
            </tbody>
        </table>
        <a id="new">Добавить контакт</a>
        <form id='new_contact' style="display:none">
        <label for="new_name">Имя</label>
        <input type='text' name='new_name' id='new_name'/>
        <label for="new_last_name">Фамилия</label>
        <input type='text' name='new_last_name' id='new_last_name'/>
        <label for="new_phone">Телефон</label>
        <input type='text' name='new_phone' id='new_phone'/><br/>
        <input type='submit' id='new_submit' value='Добавить'/>
        </form>
    </div>
<script>
$(function(){
    $.getJSON("/adress_book/controller/Contact/list.php",{},function(json){
        $("#contact_list").empty()
        for(contact in json){
            var row="";
            for(field in json[contact]) {
                if(field!='id')row+="<td>"+json[contact][field]+"</td>";
            }
            row+="<td><a href="+json[contact]['id']+" class='delete'>Удалить</a></td>";
            $("#contact_list").append("<tr id="+contact+">"+row+"</tr>");
        }
        $("#contact_table .delete").click(function(){
            event.preventDefault()
            var id=$(this).attr("href")
            $.get("/adress_book/controller/Contact/delete.php",{id:id},function(){
                document.location.href = document.location.href;
            })

        });
    })
});
$(function(){
    $("#new").click(function(){
     event.preventDefault();
     $("#new_contact").slideToggle('normal');
    })
});

$(function(){
    $("#new_submit").click(function(){
    event.preventDefault();
    var form=$("#new_contact").serialize();
        $.get("/adress_book/controller/Contact/new.php",form,function(data){
            $("#new_contact").hide();
            document.location.href = document.location.href;
        })
    })
});

$(function(){
    $("#search").blur(function(){
        var search=$(this).val();
        $.getJSON("/adress_book/controller/Contact/list.php",{search:search},function(json){
            $("#contact_list").empty()
        for(contact in json){
            var row="";
            for(field in json[contact]) {
                if(field!='id')row+="<td>"+json[contact][field]+"</td>";
            }
            row+="<td><a href="+json[contact]['id']+" class='delete'>Удалить</a></td>";
            $("#contact_list").append("<tr id="+contact+">"+row+"</tr>");
        }
        $("#contact_table .delete").click(function(){
            event.preventDefault()
            var id=$(this).attr("href")
            $.get("/adress_book/controller/Contact/delete.php",{id:id},function(){
                document.location.href = document.location.href;
            })

        });
    })

    });
});
</script>
</body>
</html>
