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
        $.post("/php_script/StudentService/studentService.php", 
               {id:id,action:action},
               function(data){
                   alert(data);
               }, 'json')
}
