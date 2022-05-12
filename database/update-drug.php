<?php
	$data = $_POST;
	$drug_id  = (int) $data['drugId'];
	$drug_name  = $data['d_name'];

	// Adding the record.
	try {			
		$sql = "UPDATE drugs SET drug_name=? WHERE id=?";
		include('connection.php');
		$conn->prepare($sql)->execute([$drug_name, $drug_id]);
		echo json_encode([
 			'success' => true,
			 'isvac' => false,
 			'message' => $drug_name . ' successfully updated.'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
			 'isvac' => false,
 			'message' => 'Error processing your request!'
		]);
	}


