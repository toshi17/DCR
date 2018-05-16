<?php

function get_time($file){
  exec("sox --i -d ".$file, $out,$rec);
  $snd = str_split($out[0]);
  $l = count($snd);
  return (int)$snd[$l-1]*10+(int)$snd[$l-2]*100+(int)$snd[$l-4]*1000;
}

// function set_ts($time){
//   $jdir = "/home/tohoku-i/www/html/data.json";
//   $json = file_get_contents($jdir);
//   $arr = json_decode($json,true);
//
//   $p = $arr["totalSpeak"];
//   $arr["totalSpeak"] += $time;
//
//   file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
//
//   return array($p, $arr["totalSpeak"]);
// }

function update_prob($file){
  $gt = get_time($file);
  // $t = set_ts($gt);
  // $pt = $t[0];
  // $nt = $t[1];

  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $fn = basename($file, ".wav");

  $n=0;
  foreach($arr["users"] as $usr){
    if($usr["id"]==substr($fn,0,strlen($fn)-4)){
      $arr["users"][$n]["prob"] += $gt;
      // $arr["users"][$n]["prob"] = ($usr["prob"] * $pt / 100 + $gt) / $nt * 100;
    }else{
      // $arr["users"][$n]["prob"] = ($usr["prob"] * $pt / 100) / $nt * 100;
    }
    $n++;
  }

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
}
?>
