<?php
ini_set('max_execution_time', 900);
$host = 'localhost';
$user = 'root';
$pass = ''; 
$db_name = 'price';   // Имя базы данных
$table_name = 'PriceIneedApple'; //Имя Таблицы

//Получаем HTML код Ineed-Apple
$InXsMax64 = file_get_contents('https://ineed-apple.ru/iphone_xs_max/apple_iphone_xs_max_64gb_gold_zoloto/');
$InXsMax256 = file_get_contents('https://ineed-apple.ru/iphone_xs_max/apple_iphone_xs_max_256gb_gold_zoloto/');
$InXs64 = file_get_contents('https://ineed-apple.ru/iphone_xs/apple_iphone_xs_64gb_Gold/');
$InXs256 = file_get_contents('https://ineed-apple.ru/iphone_xs/apple_iphone_xs_256gb_Gold/');
$InX256 = file_get_contents('https://ineed-apple.ru/iphone-x/iphone-x-256gb-seryy-kosmos/');
$InX64 = file_get_contents('https://ineed-apple.ru/iphone-x/iphone-x-64gb-space-gray/');
//Получаем приблеженную позицию к цене
$posIn1 = strpos($InXsMax64, "span class=\"price_value\"");
$posIn2 = strpos($InXsMax256, "span class=\"price_value\"");
$posIn3 = strpos($InXs64, "span class=\"price_value\"");
$posIn4 = strpos($InXs256, "span class=\"price_value\"");
$posIn5 = strpos($InX64, "span class=\"price_value\"");
$posIn6 = strpos($InX256, "span class=\"price_value\"");

$arrName = ['iPhoneXsMax64','iPhoneXsMax256','iPhoneXs64','iPhoneXs256','iPhoneX64','iPhoneX256'];
//Формируем Массив цен на модели
$arrPrice = [substr($InXsMax64, $posIn1+25,6),substr($InXsMax256, $posIn2+25,6) ,substr($InXs64, $posIn3+25,6) ,substr($InXs256, $posIn4+25,6) ,substr($InX64, $posIn5+25,6), substr($InX256, $posIn6+25,6)];
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
      echo '<p>Произошла ошибка: ' , $conn->error , '</p>';
    }
    }

  $conn->close();

  ?>
