<?php
	// Start the session.
	session_start();
	
    include('database/connection.php');

    $username = $_POST['username'];
    $password = $_POST['password'];
    $newpassword = $_POST['newpassword'];
    echo $username;
    echo $password;
    echo $newpassword;

    $query = 'SELECT * FROM users WHERE users.login="'. $username .'" AND users.password="'. $password .'"';
    $stmt = $conn->prepare($query);
    $stmt->execute();

    if($stmt->rowCount() > 0){
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetchAll()[0];
        $_SESSION['user'] = $user;
        
        $query = 'UPDATE users SET password="'. $newpassword .'" WHERE id="'. $user['id'] .'"';
        $stmt = $conn->prepare($query);
        $stmt->execute();

        header('Location: dashboard.php');
    } else echo 'Please make sure that username and password are correct.';
	
?>