<?php
define('DB_DATABASE','userdb');
define('DB_USERNAME','oike');
define('DB_PASSWORD','Oikeoike01!');
define('PDO_DSN','mysql:host=localhost;dbname=' . DB_DATABASE);

require "php/db_name.php";

$jdir = "/home/tohoku-i/www/html/data.json";
$json = file_get_contents($jdir);
$arr = json_decode($json,true);

$state = $arr['state'];

if($state==0){
  $key_id = 'user_id';
  $key_name = 'user_name';
  if(isset($_POST[$key_id]) && isset($_POST[$key_name])){
    $user_id = $_POST[$key_id];
    $user_name = $_POST[$key_name];

    try{
      $db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
      $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $db -> exec("INSERT INTO userInfo (user_id, user_name) VALUES ('$user_id', '$user_name') ON DUPLICATE KEY UPDATE user_name = '$user_name';");
      $db = null;

      $u = get_user();
      echo count($u);

    } catch(PDOException $e){
      echo $e->getMessage();
      exit;
    }
  } else {
    echo '-1';
  }
}else{
  echo '-1';
}
?>

