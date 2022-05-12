<?php
	// Start the session.
	session_start();

	$table_name = 'vaccines';
	$drug_name = $_POST['drug_name'];


	// Adding the record.
	try {			
		$command = "INSERT INTO 
								$table_name(drug_name, created_at) 
							VALUES 
								
								('".$drug_name."', NOW())";

		include('connection.php');

		$conn->exec($command);
		$response = [
			'success' => true,
			'isvac' => true,
			'message' => $drug_name . ' successfully added to the system.'
		];
	} catch (PDOException $e) {
		$response = [
			'success' => false,
			'isvac' => true,
			'message' => $e->getMessage()
		];
	}

	$_SESSION['response'] = $response;
	header('location: ../drug-add.php');
?>