<?php

include('connection.php');

$month = $_POST['month1'];
$year = $_POST['year1']; 

$stmt = $conn->prepare("SELECT * FROM writeoff_pharm WHERE YEAR(date)='".$year."' and MONTH(date)='".$month."' ORDER BY date DESC");
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
    $exp_str='Истек срок годности ' . $str_month . '.' . $year1 . ' г.';
    $command = "INSERT INTO 
								writeoff_pharm(date, amount, unit, drug_name, note) 
							SELECT sysdate(),t.amount,t.unit,t.drug_name,'".$exp_str."' FROM pharm_reg t WHERE YEAR(t.expiration)='".$year1."' and MONTH(t.expiration)='".$month1."'";
        
	include('connection.php');
	$conn->exec($command);

    $exp_str='Списание по ЧО ' . $str_month . '.' . $year1 . ' г.';
    $command = "INSERT INTO 
								writeoff_pharm(date, amount, unit, drug_name, note) 
							SELECT sysdate(),h.emergency,r.unit,r.drug_name,'".$exp_str."' FROM pharm_history h, pharm_reg r WHERE r.id=h.pharm_reg_id and h.emergency>0 and YEAR(h.date)='".$year1."' and MONTH(h.date)='".$month1."'";
        
	include('connection.php');
	$conn->exec($command);

    $stmt = $conn->prepare("SELECT * FROM writeoff_pharm WHERE YEAR(date)='".$year."' and MONTH(date)='".$month."' ORDER BY date DESC");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $lst = $stmt->fetchAll();
}
echo json_encode($lst, JSON_UNESCAPED_UNICODE); //$stmt->fetchAll()
die;