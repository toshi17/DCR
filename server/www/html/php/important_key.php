<?php
function add_i_key($key){
  $jdir = "/home/tohoku-i/www/html/key.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  foreach($key as $k){
    if(array_key_exists($k, $arr)){
      $arr[$k] += 1;
    }else{
      $arr[$k] = 1;
    }
  }

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}

function update_i_key(){
  $kjdir = "/home/tohoku-i/www/html/key.json";
  $kjson = file_get_contents($kjdir);
  $karr = json_decode($kjson,true);

  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  arsort($karr);
  $karr = (array_slice($karr,0,10));
  $n=0;
  foreach($karr as $num){
    if($num < 3){
      break;
    }
    $n++;
  }
  $karr = (array_slice($karr,0,$n));
  

  $arr['important_key'] = $karr;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}
?>
