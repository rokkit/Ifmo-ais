//набор функций для сервиса студента

//добавление в избранное
function add_to_favourite(link, id) {//тип:добавить/удалить, id: ид направления
    if($(link).hasClass("add"))
        {
            $(link).removeClass("add").addClass("remove");
            var action="add";
        }
        else {
           $(link).removeClass("remove").addClass("add");
           var action="remove";
        }
        $.post("/php_script/StudentService/add_to_favourites.php", 
               {id:id,action:action},
               function(){
                   
               }, 'json');
               return false;
}

//загрузка списка с избранным
function load_favourites(user_id) {
    $.getJSON("/php_script/StudentService/get_favourites.php", {user_id:user_id}, function(json) {
        
    })
}
