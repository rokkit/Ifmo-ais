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
                        <?php
                        }
                        ?>
                        <?php foreach($data as $f) {?>
                        <div class="cf-block well" id="<?= $f->id ?>">
                            <div class="span2 img">
                               Image 
                            </div>
                            <div class="span4">
                                <?= $f->name ?>
                                <?= $f->description ?>
                            </div>
                        </div>
                        <?php } ?>

</div>