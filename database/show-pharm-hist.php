<?php

include('connection.php');

$month = $_POST['month1'];
$year = $_POST['year1']; 

$stmt = $conn->prepare("SELECT r.date as creat_d, h.date as trans_d, r.drug_name, h.income, h.expense, h.emergency, u.name FROM `pharm_history` h, pharm_reg r, users u WHERE h.pharm_reg_id=r.id and u.id=h.user_id and YEAR(h.date)='".$year."' and MONTH(h.date)='".$month."' ORDER BY h.date DESC");
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

echo json_encode($stmt->fetchAll(), JSON_UNESCAPED_UNICODE);