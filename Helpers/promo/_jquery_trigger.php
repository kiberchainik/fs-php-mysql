<?php

$main_js = 'elements/fs-files/main.js';
$get_main_config_js = htmlspecialchars(file_get_contents($main_js));
$arr_keys_js = array('&quot;', '&lt;', '&gt;','&amp;');
$arr_value_js = array('"', '<', '>','&');
$main_config_js = str_replace($arr_keys_js, $arr_value_js, $get_main_config_js);