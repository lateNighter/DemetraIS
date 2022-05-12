<?php
	$data = $_POST;
	$drug_id  = (int) $data['drug_id'];
	$drug_name  = $data['d_name'];

	// Deleting the record.
	try {			
		$command = "DELETE FROM vaccines WHERE id={$drug_id}";
		include('connection.php');

		$conn->exec($command);

		echo json_encode([
 			'success' => true,
			 'isvac' => true,
 			'message' => $drug_name . ' successfully deleted.'
		]);
	} catch (PDOException $e) {
		echo json_encode([
 			'success' => false,
			 'isvac' => true,
 			'message' => 'Error processing your request!'
		]);
	}
