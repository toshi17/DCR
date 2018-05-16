<?php
ini_set( 'display_errors', 1 );
require "php/recognition.php";
require "php/add.php";
require "php/important_key.php";
require "php/cal_prob.php";
$wname = 'voice';

$jdir = "/home/tohoku-i/www/html/data.json";
$json = file_get_contents($jdir);
// $json = mb_convert_encoding($json, 'UTF8', 'ASCII,JIS,UTF-8,EUC-JP,SJIS-WIN');
$arr = json_decode($json,true);

$state = $arr['state'];

if($state){
  if(is_uploaded_file($_FILES[$wname]['tmp_name'])){
    if(move_uploaded_file($_FILES[$wname]['tmp_name'],'/home/tohoku-i/www/html/tmp/'.$_FILES[$wname]['name'])){
      echo "uploaded.";
      while($arr['lock']==1){
        $json = file_get_contents($jdir);
        $arr = json_decode($json,true);
      }
      $json = file_get_contents($jdir);
      $arr = json_decode($json,true);
      $arr['lock'] = 1;
      file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));

      update_prob('/home/tohoku-i/www/html/tmp/'.$_FILES[$wname]['name']);
      $out = recog('/home/tohoku-i/www/html/tmp/'.$_FILES[$wname]['name']);
      print_r($out);
      add_key($out);
      add_i_key($out);
      update_i_key();

      $json = file_get_contents($jdir);
      $arr = json_decode($json,true);
      $arr['lock'] = 0;
      file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
    }else{
      echo "-1";
    }
  } else {
    echo "-1";
  }
} else {
  echo "0";
}
?>

