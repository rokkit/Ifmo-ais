<?php
session_start();
if (isset($_SESSION['user_id']) AND $_SESSION['ip'] == $_SERVER['REMOTE_ADDR'])
{
?>
<h1>Формирование выписок</h1>
<div class="row row-content">
    <div class="span4 well" id="filter-container">
        <form id="filter-form" name="filter-form">
        <select>
            <option disabled>Год обучения</option>
        </select>
        </form>
    </div>
    <div class="span8 well">
        span8
    </div>
</div>
<?php
}
else 
{
header("Location: http://".$_SERVER['HTTP_HOST']."/");
}
?>