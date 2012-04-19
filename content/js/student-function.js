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

//получение данных и наполнение полей
function load_dir_data(direction) {
    $.getJSON("/php_script/StudentService/load_dir_data.php", {direction:direction}, function(json) {
        $("#direction-temp").val(direction);
        $("#faculty-temp-choose").text(json['name_faculty']);//название факультета
        $("#cathedra-temp-choose").text(json['name_cathedra']);//название кафедры
        $("#direction-temp-choose").text(json['name_direction']);//название направления
        $("#count-num").text(json['count_num']);//название направления
        
        var points=json['points'];
        //заполняем таблицу оценок
        for(var point in points)
            {
                var p=points[point]
                $("#stud-subject-body")
                .append("<tr><td>"+p['subject']+"</td><td>"+p['point']+"</td><td>"+p['discipline']+"</td></tr>");
            }
        })
    }


//рисуем паутиновый график
function drawWebChart(line,kf,json,params_line,params_pline) {
    var count=0;
    
    //считаем сколько секций пришло
    for(section in json) count++;
    var points=[];//массив точек параметров
    var angle=90;//начальный угол
    var angleplus=360/count;//круг делим на количество секций        
    
    //размеры листа вычисляем относительно длины линии
    var cx=line*2+55,
        cy=line*2+55,
        sx=cx/2,
        sy=cy/2;
    
    var paper = Raphael("holder-web-chart", cx,cy);
    paper.circle(sx, sy, line);
    var px=0,py=0;
    function draw_text(cx,cy,delta,angle,text) {
     angle=angle*(Math.PI/180);//перегоняем в рады
     var tx=cx-delta*Math.cos(angle),
         ty=cy-delta*Math.sin(angle);//
        return paper.text(tx,ty,text);
    }
    function draw_line(cx,cy,line,angle, label){//центр графика, длина линии, угол наклона
        angle=angle*(Math.PI/180);//перегоняем в рады
        var x=cx-line*Math.cos(angle),
            y=cy-line*Math.sin(angle);//координаты конца линии
            
         
            
        var num=line/kf+json[label];//нормализуем масштаб графика
            px=cx-num*Math.cos(angle),
            py=cy-num*Math.sin(angle);//координаты точки со значением параметра
            points.push([px,py]);
            
        return paper.path(["M",cx,cy,"L",x,y]).attr(params_line);
    }
    function draw_parametric_line(x1,y1,x2,y2) {//координаты начала  конца, значение параметра
        return paper.path(["M",x1,y1,"L",x2,y2]).attr(params_pline);
    }

    for(var section in json)//выбираем по секции и рисуем линии
        {           
            draw_line(sx, sy, line, angle,section);//рисуем линии координат
            draw_text(sx, sy ,line+15, angle, section);
            angle+=angleplus;//двигаем по углу
        }
    for(i=0;i<=points.length-1;i++) 
        {
            if(i!=points.length-1) draw_parametric_line(points[i][0], points[i][1], points[i+1][0], points[i+1][1]);
            else draw_parametric_line(points[i][0], points[i][1], points[0][0], points[0][1])
        }
}
