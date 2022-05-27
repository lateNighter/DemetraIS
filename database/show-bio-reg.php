<?php

include('connection.php');

$month = $_POST['month1'];
$year = $_POST['year1']; 

$stmt = $conn->prepare("SELECT * FROM bio_reg WHERE YEAR(date)='".$year."' and MONTH(date)='".$month."' ORDER BY date DESC"); //YEAR(date)='".$year."' and MONTH(date)='".$month."'
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$lst = $stmt->fetchAll();

$curmonth = idate('m');
$curyear = idate('Y');
if (count($lst)==0&&$curmonth==$month&&$curyear==$year){
    $year1=$year;
    $month1=$month-1;
    if($month==1){
        $year1=$year-1;
        $month1=12;
    }
    $str_month = $month1;
    if($month1<10){
        $str_month = '0' . $month1;
    }

    $command = "INSERT INTO 
								bio_reg(date, drug_name, unit, amount, expiration, serial_n, note) 
							SELECT sysdate(),drug_name,unit,amount,expiration,serial_n,note FROM bio_reg WHERE YEAR(date)='".$year1."' and MONTH(date)='".$month1."' and amount>0";
        
	include('connection.php');
	$conn->exec($command);

    $stmt = $conn->prepare("SELECT * FROM bio_reg WHERE YEAR(date)='".$year."' and MONTH(date)='".$month."' ORDER BY date DESC"); //YEAR(date)='".$year."' and MONTH(date)='".$month."'
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $lst = $stmt->fetchAll();
}
echo json_encode($lst, JSON_UNESCAPED_UNICODE); //$stmt->fetchAll()
die;