<?php
ini_set('max_execution_time', 900);
$host = 'localhost';  
$user = 'root';    
$pass = ''; 
$db_name = 'price';   
$table_name = 'PriceIWBM'; //Имя Таблицы

//Получаем HTML код IWBM
$IwXsMax64 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-xs-max/apple-iphone-xs-max-gold');
$IwXsMax256 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-xs-max/apple-iphone-xs-max-256gb-gold');
$IwXs64 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-xs/iphone-xs-gold');
$IwXs256 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-xs/apple-iphone-xs-256gb-gold');
$IwX256 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-7s/smartfon-apple-iphone-x-256gb-space-gray');
$IwX64 = file_get_contents('https://iwbm.ru/smartphones/apple-iphone/iphone-7s/apple-iphone-x-64gb-space-gray');
//Получаем приблеженную позицию к цене 
$posIw1 = strpos($IwXsMax64, "id=\"price-special\"");
$posIw2 = strpos($IwXsMax256, "id=\"price-special\"");
$posIw3 = strpos($IwXs64, "id=\"price-special\"");
$posIw4 = strpos($IwXs256, "id=\"price-special\"");
$posIw5 = strpos($IwX64, "id=\"price-old\"");//СДЕЛАТЬ ОБРАБОТКУ ЕСЛИ ИЗМЕНЯТ ЦЕНУ НА САЙТ НА PRICE CPECIAL
$posIw6 = strpos($IwX256, "id=\"price-old\"");

$arrName = ['iPhoneXsMax64','iPhoneXsMax256','iPhoneXs64','iPhoneXs256','iPhoneX64','iPhoneX256'];
//Формируем Массив цен на модели
$arrPrice = [substr($IwXsMax64, $posIw1+19,6),substr($IwXsMax256, $posIw2+19,6) ,substr($IwXs64, $posIw3+19,6) ,substr($IwXs256, $posIw4+19,6) ,substr($IwX64, $posIw5+15,6), substr($IwX256, $posIw6+15,6)];
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
