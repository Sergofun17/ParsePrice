<?php
ini_set('max_execution_time', 900);
$host = 'localhost';  
$user = 'root';    
$pass = ''; 
$db_name = 'price';                // Имя базы данных
$table_name = 'PriceAppleManager'; //Имя Таблицы

//Получаем HTML код Apple-Manager
$AmXsMax64 = file_get_contents('http://apple-manager.ru/iphone-xs-max/64gb-gold/');
$AmXsMax256 = file_get_contents('http://apple-manager.ru/iphone-xs-max/256gb-gold/');
$AmXs64 = file_get_contents('http://apple-manager.ru/iphone-xs/64gb-gold/');
$AmXs256 = file_get_contents('http://apple-manager.ru/iphone-xs/256gb-gold/');
$AmX64 = file_get_contents('http://apple-manager.ru/iphone-x/64gb-space-gray/');
$AmX256 = file_get_contents('http://apple-manager.ru/iphone-x/256gb-space-gray/');
//Получаем приблеженную позицию цены
$posAm1 = strpos ($AmXsMax64, "span class=\"rub\"");
$posAm2 = strpos ($AmXsMax256, "span class=\"rub\"");
$posAm3 = strpos ($AmXs64, "span class=\"rub\"");
$posAm4 = strpos ($AmXs256, "span class=\"rub\"");
$posAm5 = strpos ($AmX64, "span class=\"rub\"");
$posAm6 = strpos ($AmX256, "span class=\"rub\"");
//Массив Моделей
$arrName = ['iPhoneXsMax64','iPhoneXsMax256','iPhoneXs64','iPhoneXs256','iPhoneX64','iPhoneX256'];
//Формируем Массив цен на модели
$arrPrice = [substr($AmXsMax64, $posAm1-9,7),substr($AmXsMax256, $posAm2-9,7) ,substr($AmXs64, $posAm3-9,7) ,substr($AmXs256, $posAm4-9,7) ,substr($AmX64, $posAm5-9,7), substr($AmX256, $posAm6-9,7)];
//Удаляем если есть пробелы 
for($i=0;$i<count($arrPrice);$i++){
	$arrPrice[$i]=str_replace(' ','',$arrPrice[$i]);
}

$conn = new mysqli($host, $user, $pass, $db_name); // Соединяемся с базой
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);}
$conn->query("TRUNCATE TABLE $table_name"); //Очищаем таблицу

for($i=0;$i<count($arrPrice);$i++){
    $sql = $conn->query("INSERT INTO `$table_name` VALUES ($i+1,'$arrName[$i]', '$arrPrice[$i]')");
    if ($sql) {
      echo '<p>Данные успешно добавлены в таблицу.</p>';
    } else {
      echo '<p>Произошла ошибка: ' , $conn->error, '</p>';
    }
    }
    // Если соединение установить не удалось
    
  $conn->close();
  ?>


	
