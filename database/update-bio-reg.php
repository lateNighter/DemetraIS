<?php
	header("Content-type: application/json");
	session_start();
	$user = $_SESSION['user']['id'];
	$data = $_POST;
	$reg_id  = (int) $data['regId'];
	$ctime  = $data['ctime'];
	$drug_name  = $data['d_name'];
	$income  = (float) $data['income'];
	$expense  = (float) $data['expense']; 
	$emergency  = (float) $data['emergency'];
	$amount  = (float) $data['amount'];

	try {			
		$amount=$amount+$income-$expense-$emergency;
		if($amount<0){
			echo json_encode([
				'success' => false,
			   'message' => 'amount<0'
		   ]);
		   return;
		}
		$sql = "UPDATE bio_reg SET amount=? WHERE id=?";
		include('connection.php');
		$conn->prepare($sql)->execute([$amount, $reg_id]);

		$command2 = "INSERT INTO bio_history(date, user_id, bio_reg_id, income, expense, emergency) VALUES (NOW(), ?, ?, ?, ?, ?)";
        // $command2->execute([$user, $reg_id, $income, $expense, $emergency]);
		$conn->prepare($command2)->execute([$user, $reg_id, $income, $expense, $emergency]);

		echo json_encode([
 			'success' => true,
			'message' => 'successfully updated'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
			'message' => $e->getMessage()
		]);
	}