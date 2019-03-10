<?php
ini_set('max_execution_time', 900);
$host = 'localhost'; 
$user = 'root';    
$pass = ''; 
$db_name = 'price';   
$table_name = 'PriceiPhoneSib'; //Имя Таблицы

//Получаем HTML код iPhoneSib
$IsXsMax64 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/508?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=64');
$IsXsMax256 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/508?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=8');
$IsXs64 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/498?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=64');
$IsXs256 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/498?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=8');
$IsX256 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/451?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=8');
$IsX64 = file_get_contents('https://phonesib.ru/component/jshopping/product/ajax_attrib_select_and_price/451?ajax=1&Itemid=0&change_attr=2&qty=1&attr[1]=4&attr[2]=64');

//Получаем приблеженную позицию к цене
$posIs1 = strpos ($IsXsMax64, "pricefloat");
$posIs2 = strpos ($IsXsMax256, "pricefloat");
$posIs3 = strpos ($IsXs64, "pricefloat");
$posIs4 = strpos ($IsXs256, "pricefloat");
$posIs5 = strpos ($IsX64, "pricefloat");
$posIs6 = strpos ($IsX256, "pricefloat");
$arrName = ['iPhoneXsMax64','iPhoneXsMax256','iPhoneXs64','iPhoneXs256','iPhoneX64','iPhoneX256'];
//Формируем Массив цен на модели
$arrPrice = [substr($IsXsMax64, $posIs1+13,5),substr($IsXsMax256, $posIs2+13,5) ,substr($IsXs64, $posIs3+13,5) ,substr($IsXs256, $posIs4+13,5) ,substr($IsX64, $posIs5+13,5), substr($IsX256, $posIs6+13,5)];
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