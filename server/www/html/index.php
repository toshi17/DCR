<?php
$user = 'admin';
$password = 'pass';

if (!isset($_SERVER['PHP_AUTH_USER'])){
  header('WWW-Authenticate: Basic realm="Private Page"');
  header('HTTP/1.0 401 Unauthorized');

  die('このページを見るにはログインが必要です');
}else{
  if ($_SERVER['PHP_AUTH_USER'] != $user
    || $_SERVER['PHP_AUTH_PW'] != $password){

      header('WWW-Authenticate: Basic realm="Private Page"');
      header('HTTP/1.0 401 Unauthorized');
      die('このページを見るにはログインが必要です');
    }
}

?>

<!DOCTYPE html>
<html>
<head>
<title>Preparing for disscussion</title>
<link rel="stylesheet" type="text/css" href="css/style_index.css">
<meta charset = "utf-8">
<script>
var addCount = 1;
function addTable(){
  var element = document.createElement('tr');
  element.innerHTML = "<td><select class = \"pulldown\" name = \"mode["+ addCount +"]\" ><option value=\"0\">ディスカッション</option><option value=\"1\">休憩</option><option value=\"2\">共有</option></select></td><td><input class = \"input3\" type=\"text\" name=\"time["+ addCount +"]\"> </td><td><input class = \"input3\" type=\"text\" name=\"subTheme["+ addCount +"]\"></td>";
  document.getElementById("timeTable").firstElementChild.appendChild(element);
  addCount += 1;
}
</script>
</head>
<body>
<div id="wrapper">
  <form method="post" action="start.php">
    <div id="id001">さあディスカッションに向けて準備をしよう</div>
    <div id ="id002">グループ名　　　　: <input id = "input1" type="text" name="group"></div>
    <div id ="id003">今日のメインテーマ: <input id = "input2" type="text" name="theme"></div>
    <table id="timeTable" border="3" summary="タイムテーブル">
      <tr>
        <th>モード</th>
        <th>時間</th>
        <th>テーマ</th>
      </tr>
      <tr>
        <td>
          <select class = "pulldown" name = "mode[0]" >
            <option value="0">ディスカッション</option>
            <option value="1">休憩</option>
            <option value="2">共有</option>
          </select>
        </td>
        <td><input class = "input3" type="text" name="time[0]"> </td>
        <td><input class = "input3" type="text" name="subTheme[0]"></td>
      </tr>
    </table>
    <button id ="button_add" type="button" onclick="addTable();">追加</button>
    <button id ="button1" type="submit"><p id="sendButtonText">Let's start disscussion!!</button>
  </form>
</div>

</body>
</html>

