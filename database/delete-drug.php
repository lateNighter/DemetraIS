<?php
	$data = $_POST;
	$drug_id  = (int) $data['drug_id'];
	$drug_name  = $data['d_name'];

	// Deleting the record.
	try {			
		$command = "DELETE FROM drugs WHERE id={$drug_id}";
		include('connection.php');

		$conn->exec($command);

		echo json_encode([
 			'success' => true,
			 'isvac' => false,
 			'message' => $drug_name . ' successfully deleted.'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
			 'isvac' => false,
 			'message' => 'Error processing your request!'
		]);
	}


