<?php session_start();
define('FNPATH', $_SERVER['DOCUMENT_ROOT']."/php_script/");
require FNPATH.'auth.php';
//require FNPATH.'StudentService/auth.php';
?>
<title>НИУ ИТМО | Кафедра</title>
<?php include '../../php_script/StudentService/studentService.php'; ?>

<div class="row">
                        <?php
                        if($_REQUEST['faculty']) {
                        $data = getBlockCathedra($_REQUEST['faculty']);
                        ?>
<script>
    $(function(){$(".page-header h3").text("Выбор кафедры")});
</script>
<script type="text/javascript">
    $(function(){
      // pjax
$.hash = '#!/';
$.siteurl = '<?php echo $_SERVER['HTTP_HOST']; ?>';
$.container = '#st-content';
$('.cf-block').click(function(){
           $('.cf-block').pjax({
                url:'cservice.php?cathedra='+$(this).attr("id"),
                container:'#st-content'});//аякс запрос направлений
            })

    })
</script>
                    <script>
                        $(function() {
                            $("#content-nav").children("li").each(function(){
                               $(this).removeClass("current-nav");
                            });
                            $("#content-nav #step2").addClass("current-nav");
                        });
                    </script>
                        <?php
                        }
                        else if($_REQUEST['cathedra']) {
                        $data=getBlockDirection($_REQUEST['cathedra']);
                        ?>
<script>
  $(function(){$(".page-header h3").text("Выбор направления")});
</script>
<script type="text/javascript">
    $(function(){
      // pjax
$.hash = '#!/';
$.siteurl = '<?php echo $_SERVER['HTTP_HOST']; ?>';
$.container = '#st-content';
$('.cf-block').click(function(){
           $('.cf-block').pjax({
                url:'dservice.php?direction='+$(this).attr("id"),
                container:'#st-content'});//аякс запрос направлений
            })

    })
  </script>
                    <script>
                        $(function() {
                            $("#content-nav").children("li").each(function(){
                               $(this).removeClass("current-nav");
                            });
                            $("#content-nav #step3").addClass("current-nav");
                        });
                    </script>
                        <?php
                        }
                        ?>
                        <?php foreach($data as $f) {?>
    <div class="favourite span1">
        <a class="star <?php echo checkFavourite($f->id)?>" title="Добавить в избранное" onclick="add_to_favourite(this,<?= $f->id ?>)" href="#"></a>
    </div>
                        <div class="cf-block well" id="<?php echo $f->id ?>">

                                <strong><?php echo $f->full_name." (".$f->name.")" ?></strong><br>
                                <?php echo $f->description ?>

                        </div>

                    <script>
                    //прячем звездочки
                    $(function() {
                        if($("#step2").hasClass("current-nav")) $(".star").hide();
                        if($("#step3").hasClass("current-nav")) $(".star").show();
                    });
                    </script>
                        <?php } ?>

</div>
