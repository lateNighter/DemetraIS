<?php
	// Start the session.
	session_start();

	$table_name = $_SESSION['table'];
	$date = $_POST['date'];
	$temperature = $_POST['temperature'];
    $date_for_database = date ('Y-m-d H:i:s', strtotime($date));

	// Adding the record.
	try {			
		$command = "INSERT INTO 
								$table_name(rec_date, temperature) 
							VALUES 
								
								('".$date_for_database."', '".$temperature."')";

		include('connection.php');

		$conn->exec($command);
		$response = [
			'success' => true,
			'message' => 'Record successfully added to the system.'
		];
		
	} catch (PDOException $e) {
		$response = [
			'success' => false,
			'message' => $e->getMessage()
		];
	}

	$_SESSION['response'] = $response;
	header('location: ../fridge.php');
?>