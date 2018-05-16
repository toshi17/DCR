<?php
require "db_name.php";

function init(){
  exec("sh initialize.sh");
}

function add_users(){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $user = get_user();
  $n=0;
  $arr["users"] = array();
  foreach($user as $id=>$name){
    $arr["users"][$n]["id"]=(string)$id;
    $arr["users"][$n]["name"]=$name;
    $arr["users"][$n]["prob"]=0;
    $n=$n+1;
  }

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_theme($theme){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["theme"] = $theme;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_table($state,$time,$sub){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $n=0;
  foreach($state as $s){
    $arr["timeTable"][$n]["state"] = $state[$n];
    $arr["timeTable"][$n]["time"] = (int)$time[$n];
    $arr["timeTable"][$n]["subTheme"] = $sub[$n];
    $n++;
  }

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_starttime($time){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["startTime"] = $time;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_group($name){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["groupName"] = $name;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_key($key){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["keywords"] = array_merge($arr["keywords"],$key);

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function add_lazy($time){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr["lazy_time"] += $time;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}
?>
