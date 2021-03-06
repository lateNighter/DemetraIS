<?php

include('connection.php');

$stmt = $conn->prepare("select f.id, f.rec_date, f.temperature from fridge f inner join (select max(id) as maxid from fridge group by rec_date) maxt on (f.id = maxt.maxid);");//SELECT * FROM fridge ORDER BY rec_date DESC
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$arr = $stmt->fetchAll();
$lst = array();
foreach ($arr as &$value) {
    $color = 'bg-red-alt';
    if ($value['temperature'] > 3 && $value['temperature'] < 13){
        $color = 'bg-green-alt';
    } 
    array_push($lst, array('time' => $value['rec_date'], 'cls' => $color, 'desc' => $value['temperature'] . '°C'));
}


echo json_encode($lst);
// return $stmt->fetchAll();