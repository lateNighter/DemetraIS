<?php
	// Start the session.
	session_start();

	$table_name = 'pharm_reg';
	$drug_name = $_POST['drug_name'];
    $user = $_SESSION['user']['id'];

	// Adding the record.
	try {			
		$command = "INSERT INTO 
								$table_name(date, drug_name, unit, amount, expiration, serial_n, note) 
							VALUES 
								(NOW(), '".$drug_name."', '".$_POST['unit']."', '".$_POST['quantity']."', '".$_POST['expiration']."', '".$_POST['serial_n']."', '".$_POST['note']."')";
        
		include('connection.php');
		$conn->exec($command);

        $command1 = $conn->prepare("SELECT LAST_INSERT_ID()");
        $command1->execute();
        $command1->setFetchMode(PDO::FETCH_COLUMN,0);
        $ind = $command1->fetchAll()[0]; 

        $command2 = $conn->prepare("INSERT INTO 
                                        pharm_history(date, user_id, pharm_reg_id, income, expense, emergency) 
                                    VALUES 
                                        (NOW(), ?, ?, ?, ?, ?)");
        $command2->execute([$user, $ind, $_POST['quantity'], 0, 0]);



        $conn->exec($command2);
		$response = [
			'success' => true,
			'message' => $drug_name . ' successfully added to the registry.'
		];
	} catch (PDOException $e) {
		$response = [
			'success' => false,
			'message' => $e->getMessage() . ' ' . $user  . ' ' . var_dump($_SESSION)
		];
	}

	$_SESSION['response'] = $response;
	header('location: ../dashboard.php');
