<?php
ini_set('max_execution_time', 900);
$host = 'localhost';  
$user = 'root';    
$pass = ''; 
$db_name = 'price';  
$table_name = 'pricestorebox'; //Имя Таблицы

//Получаем HTML код Apple-Manager
$SbXsMax64 = file_get_contents('http://storebox.su/smartphones/iphone/xsmaxgold64');
$SbXsMax256 = file_get_contents('http://storebox.su/smartphones/iphone/xsmaxgold256');
$SbXs64 = file_get_contents('http://storebox.su/smartphones/iphone/xsgold64');
$SbXs256 = file_get_contents('http://storebox.su/smartphones/iphone/xsgold256');
$SbX256 = file_get_contents('http://storebox.su/smartphones/iphone/xgray256');
$SbX64 = file_get_contents('http://storebox.su/smartphones/iphone/xgray64');
//Получаем приблеженную позицию к цене
$posSb1 = strpos($SbXsMax64, "itemprop=\"price\"");
$posSb2 = strpos($SbXsMax256, "itemprop=\"price\"");
$posSb3 = strpos($SbXs64, "itemprop=\"price\"");
$posSb4 = strpos($SbXs256, "itemprop=\"price\"");
$posSb5 = strpos($SbX64, "itemprop=\"price\"");
$posSb6 = strpos($SbX256, "itemprop=\"price\"");

$arrName = ['iPhoneXsMax64','iPhoneXsMax256','iPhoneXs64','iPhoneXs256','iPhoneX64','iPhoneX256'];
//Формируем Массив цен на модели
$arrPrice = [substr($SbXsMax64, $posSb1+26,5),substr($SbXsMax256, $posSb2+26,5) ,substr($SbXs64, $posSb3+26,5) ,substr($SbXs256, $posSb4+26,5) ,substr($SbX64, $posSb5+26,5), substr($SbX256, $posSb6+26,5)];
//Удаляем если есть пробелы 
for($i=0;$i<count($arrPrice);$i++){
	$arrPrice[$i]=str_replace(' ','',$arrPrice[$i]);
}

$conn = new mysqli($host, $user, $pass, $db_name); // Соединяемся с базой
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}
$conn->query("TRUNCATE TABLE $table_name");//Очищаем таблицу
for($i=0;$i<count($arrPrice);$i++){
    $sql = $conn->query("INSERT INTO `$table_name` VALUES ($i+1,'$arrName[$i]', '$arrPrice[$i]')");
    if ($sql) {
      echo '<p>Данные успешно добавлены в таблицу.</p>';
    } else {
      echo '<p>Произошла ошибка: ' , $conn->error, '</p>';
    }
    }
  $conn->close();
  ?>
