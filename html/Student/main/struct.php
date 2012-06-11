<title>Бакалавриат</title>
<div class="container">
    <div class="row">
        <div class="span8">

        </div>
    </div>
    <div class="row">
        <div class="span3 well truewell">
        <h3>Структура бакалавриата</h3>
            <form id="sel-struct">
            <select id="faculty" name="faculty" class="input-large">
                <option>Пусто</option>
            </select>


                <select id="cathedra" name="cathedra" class="input-large" style="display: none">
                    <option>Пусто</option>
                </select>


                <select id="direction" name="direction" class="input-large" style="display: none">
                    <option>Пусто</option>
                </select>
            <form>
        </div>
        <div class="span8 well truewell">
            <div class="btn-download">
                <a class="btn" href="/content/files/"><i class="icon-download"></i> Скачать учебный план</a>
            </div>
            <h3 id="full-name"></h3>
            <div id="struct-info">
                Декан факультета:<p id="dekan"></p>
                Зав.кафедры:<p id="zavcath"></p>
                <p><a id="site">Сайт кафедры</a></p>
                Приблизительная стоимость контрактного обучения<p id="price"></p>
            </div>
        </div>
        <div class="row">
           <div class="span8 well truewell" style="margin:0 0 0 400px">
                <div id="f-desc" style="margin-bottom:20px">

                </div>
                <div id="c-desc">

                </div>
           </div>
        </div>

    </div>

</div>
<script>
    $(function(){
        $.getJSON("/php_script/StudentService/struct/getStructContent.php",{},function(json){
            //забиваем селект факультета
            for(var key in json['faculty_list']){
                var fac=json['faculty_list'][key]
                $("#faculty").get(0).add(new Option(fac['name'],fac['id'],true))
                }
        });
    });

    $(function(){
        //выводим инфу о факультете
        $("select").change(function(){
            if($(this).val()!=null) {
                var form=$("#sel-struct").serialize()
                $.getJSON("/php_script/StudentService/struct/getStructContent.php",form,function(json){
                    if(json['faculty']!=null) {
                        var f=json['faculty'][0];
                        if(f["name"]!=null) $("#full-name").text(f['name'])
                            $("#dekan").text(f['dekan'])
                            $("#f-desc").text(f['desc'])
                    }
                    if(json['cathedra']!=null) {
                        var c=json['cathedra'];
                        if(c["name"]!=null) $("#full-name").append(" "+c["name"]);
                        $("#zavcath").text(c["zavcath"]);
                        $("#c-desc").text(c['desc'])
                        $("#site").attr("href",c['site'])
                    }
                    if(json['direction']!=null) {
                        var c=json['direction'];
                        if(c["name"]!=null) $("#full-name").append(" "+c["name"]);
                        $("#price").text(c['price']+"р/год");
                    }
                });
            }
        });
    })

    $(function()
    {
        $('#faculty').chainSelect('#cathedra','/php_script/data_edit_get.php',
            {
                before:function (target) //before request hide the target combobox and display the loading message
                {
                    //$("#loading").css("display","block");
                    $(target).css("display","none");


                },
                after:function (target) //after request show the target combobox and hide the loading message
                {
                    //$("#loading").css("display","none");
                    $(target).css("display","block");
                    $("#cathedra-lbl").toggle();

                }

            });
        $("#cathedra").click(function(){
            $('#cathedra').chainSelect('#direction','/php_script/data_edit_get.php',
                {
                    before:function (target) //before request hide the target combobox and display the loading message
                    {
                        //$("#loading").css("display","block");
                        $(target).css("display","none");
                    },
                    after:function (target) //after request show the target combobox and hide the loading message
                    {
                        //$("#loading").css("display","none");
                        $(target).css("display","block");
                        $("#direction-lbl").toggle();
                    }
                });
        });

    });
</script>
