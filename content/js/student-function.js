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
    $.getJSON("/php_script/StudentService/get_favourites.php", {user_id:user_id}, function(data) {
        for(i=0;i<data.length;i++)
            {
                $("#nav-tabs").append("<li id="+data[i]['id']+"><a href='#' data-toggle=tab>"+data[i]['name']+" "+data[i]['name_faculty']+"</a></li>")
            }
    })
}

//рисуем паутиновый график
function drawWebChart(line,json) {
    var count=0;
    //считаем сколько секций пришло
    for(section in json) count++;
    
    var angle=90;//начальный угол
    var angleplus=360/count;//круг делим на количество секций        
    
    //размеры листа вычисляем относительно длины линии
    var cx=line*2,
        cy=line*2,
        sx=cx/2,
        sy=cy/2;
    
    var paper = Raphael("holder-web-chart", cx, cy);
    paper.circle(sx, sy, line);
    
    function draw_line(cx,cy,line,angle){//центр графика, длина линии, угол наклона
        angle=angle*(Math.PI/180);//перегоняем в рады
        var x=cx-line*Math.cos(angle),
            y=cy-line*Math.sin(angle);
        return paper.path(["M",cx,cy,"L",x,y]);
    }    
    for(var section in json)//выбираем по секции и рисуем линии
        {
            
            draw_line(sx, sy, line, angle);
            angle+=angleplus;
        }
}
