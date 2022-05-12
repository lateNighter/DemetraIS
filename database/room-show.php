<?php

include('connection.php');

$stmt = $conn->prepare("SELECT * FROM room ORDER BY rec_date DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$arr = $stmt->fetchAll();
$lst = array();
foreach ($arr as &$value) {
    $color = 'bg-red-alt';
    if ($value['temperature'] > 17 && $value['temperature'] < 23){
        $color = 'bg-green-alt';
    } 
    array_push($lst, array('time' => $value['rec_date'], 'cls' => $color, 'desc' => $value['temperature'] . '°C'));
    $color = 'bg-red-alt';
    if ($value['humidity'] > 49 && $value['humidity'] < 66){
        $color = 'bg-green-alt';
    } 
    array_push($lst, array('time' => $value['rec_date'], 'cls' => $color, 'desc' => $value['humidity'] . '%'));
}


echo json_encode($lst);
// return $stmt->fetchAll();