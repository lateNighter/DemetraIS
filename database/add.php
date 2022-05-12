<?php
	// Start the session.
	session_start();

	$table_name = $_SESSION['table'];
	$drug_name = $_POST['drug_name'];
	// $first_name = $_POST['first_name'];
	// $last_name = $_POST['last_name'];
	// $email = $_POST['email'];
	// $password = $_POST['password'];
	// $encrypted = password_hash($password, PASSWORD_DEFAULT);


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
			'isvac' => false,
			'message' => $drug_name . ' successfully added to the system.'
		];
	} catch (PDOException $e) {
		$response = [
			'success' => false,
			'isvac' => false,
			'message' => $e->getMessage()
		];
	}

	$_SESSION['response'] = $response;
	header('location: ../drug-add.php');
?>