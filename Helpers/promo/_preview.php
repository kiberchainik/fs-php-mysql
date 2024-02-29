<?php
$filename = "App/View/martup/promo/".$user_login.".html";
$previewFile = fopen($filename, "w");
fwrite($previewFile, stripcslashes($_POST['page']));
fclose($previewFile);
header('Location: '.$filename);
?>