<?php
    $conn = new mysqli('localhost','root','','price');
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
?>
<head></head>
<body class="page_bg">
	 <table border="1">
   <tr>
   	<th></th>
    <th>Цена AppleManager</th>
    <th>Цена iPhoneSib</th>
    <th>Цена iNeed</th>
    <th>Цена StoreBox</th>
    <th>Цена IWBM</th>
   </tr>
   <tr>
    <?php 
    $arrayModel = ['iPhone Xs Max 64','iPhone Xs Max 256','iPhone Xs 64Gb','iPhone Xs 256Gb','iPhone X 64Gb','iPhone X 256Gb'];
    $resAM = $conn->query("SELECT Price FROM `priceAppleManager` ");
    $resIS = $conn->query("SELECT Price FROM `priceiPhoneSib` ");
    $resIN = $conn->query("SELECT Price FROM `priceiNeedApple` ");
    $resSB = $conn->query("SELECT Price FROM `priceStoreBox` ");
    $resIW = $conn->query("SELECT Price FROM `priceIWBM` ");
    for($i=1;$i<=$resAM->num_rows;$i++){
        echo '<tr><td>',$arrayModel[$i-1],'</td>';
        echo '<td>',$resAM->fetch_assoc()['Price'],'</td>';
        echo '<td>',$resIS->fetch_assoc()['Price'],'</td>';
        echo '<td>',$resIN->fetch_assoc()['Price'],'</td>';
        echo '<td>',$resSB->fetch_assoc()['Price'],'</td>';
        echo '<td>',$resIW->fetch_assoc()['Price'],'</td></tr>';
    }
    ?>
 </table>