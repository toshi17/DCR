<?php
require "php/add.php";
init();
add_users();
add_group(htmlspecialchars_decode($_POST['group']));
add_theme(htmlspecialchars_decode($_POST['theme']));
add_starttime(time());
add_table(array_map(htmlspecialchars_decode,$_POST['mode']),array_map(htmlspecialchars_decode, $_POST['time']),array_map(htmlspecialchars_decode, $_POST['subTheme']));
$url = 'http://163.44.172.216/main.html';
header("Location: {$url}");
exit;
?>

