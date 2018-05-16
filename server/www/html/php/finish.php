<?php
define('DB_DATABASE','userdb');
define('DB_USERNAME','oike');
define('DB_PASSWORD','Oikeoike01!');
define('PDO_DSN','mysql:host=localhost;dbname=' . DB_DATABASE);

function finish(){
  $jdir = "/home/tohoku-i/www/html/data.json";
  $json = file_get_contents($jdir);
  $arr = json_decode($json,true);

  $arr['state'] = 0;

  file_put_contents($jdir,json_encode($arr,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT));
  try{
    $key_id = 'user_id';
    $key_name = 'user_name';
    $db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $db->prepare('DELETE FROM userInfo');
    $stmt->execute();

    $db = null;

  } catch(PDOException $e){
    echo $e->getMessage();
    exit;
  }

}
?>
