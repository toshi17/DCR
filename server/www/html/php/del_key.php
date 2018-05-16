<?php
//function del_key(){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["keywords"] = [];

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
//}
?>
