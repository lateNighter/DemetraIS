<?php
	$data = $_POST;
	$drug_id  = (int) $data['drugId'];
	$drug_name  = $data['d_name'];

	// Adding the record.
	// $_COOKIE['isvac'] = true;
	try {			
		$sql = "UPDATE vaccines SET drug_name=? WHERE id=?";
		include('connection.php');
		$conn->prepare($sql)->execute([$drug_name, $drug_id]);
		echo json_encode([
 			'success' => true,
			 'isvac' => true,
 			'message' => $drug_name . ' successfully updated.'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
			 'isvac' => true,
 			'message' => 'Error processing your request!'
		]);
	}

