<?php

include('connection.php');

$month = $_POST['month1'];
$year = $_POST['year1']; 

$stmt = $conn->prepare("SELECT * FROM `writeoff_pharm` WHERE YEAR(date)='".$year."' and MONTH(date)='".$month."' ORDER BY date DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);