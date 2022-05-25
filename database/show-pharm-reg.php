<?php

include('connection.php');

$month = $_POST['month1'];
$year = $_POST['year1']; 

$stmt = $conn->prepare("SELECT * FROM pharm_reg WHERE amount!=0 ORDER BY date DESC"); //YEAR(date)='".$year."' and MONTH(date)='".$month."'
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$lst = $stmt->fetchAll();

echo json_encode($lst, JSON_UNESCAPED_UNICODE); //$stmt->fetchAll()