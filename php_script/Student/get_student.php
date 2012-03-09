<?php
if (!isset($_SERVER['HTTP_X_PJAX']))
{
  echo 'NEEE';
}
else {
    echo "OK";
}
?>
