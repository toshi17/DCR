<?php
define('DB_DATABASE','userdb');
define('DB_USERNAME','oike');
define('DB_PASSWORD','Oikeoike01!');
define('PDO_DSN','mysql:host=localhost;dbname=' . DB_DATABASE);


function get_user(){
  try{
    $key_id = 'user_id';
    $key_name = 'user_name';
    $db = new PDO(PDO_DSN,DB_USERNAME,DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $info = $db->query('SELECT * FROM userInfo');
    $user = array();
    foreach($info as $row){
      $user[$row[$key_id]]=$row[$key_name];
    }

    $db = null;

    return $user;

  } catch(PDOException $e){
    echo $e->getMessage();
    exit;
  }
}
?>

