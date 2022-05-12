<?php
	// Start the session.
	session_start();
	if(isset($_SESSION['user'])) header('location: dashboard.php');

	$error_message = '';

	if($_POST){
		include('database/connection.php');

		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = 'SELECT * FROM users WHERE users.login="'. $username .'" AND users.password="'. $password .'"';
		$stmt = $conn->prepare($query);
		$stmt->execute();

		if($stmt->rowCount() > 0){
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			$user = $stmt->fetchAll()[0];
			$_SESSION['user'] = $user;

			header('Location: dashboard.php');
		} else $error_message = 'Please make sure that username and password are correct.';
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Деметра ИС</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" href="images/cow.png">
</head>
<body id="loginBody">
	<?php if(!empty($error_message)) { ?>
		<div id="errorMessage">
			<strong>ERROR:</strong> </p><?= $error_message ?> </p>
		</div>
	<?php } ?>
	<div class="container">
		
	<header>
		<!-- <img src="images/logo1.png"> -->
        <h1 class="title_ind">Деметра ИС</h1>  
		<a href="">?</a>
    </header>
    <main>
		<div class="cowbox">
			<img src="images/cow.png">
			<p>Информационная система ветеринарной аптеки</p>
		</div>
        <form class="form2" action="index.php" method="POST">
			<div class="form-header1">
				<h2>Вход в систему</h2>
			</div>
			<div class="horizontal-gradient"></div>
            <div class="form-main1">
				<div class="box">
					<label>Логин</label>
					<input placeholder="username" name="username" type="text" />
				</div>
				<div class="box">
					<label>Пароль</label>
					<input placeholder="password" name="password" type="password" />
				</div>
            </div>
            <div class="horizontal-gradient"></div>
            <div class="form-footer1">
                <a href="">Забыли пароль?</a>
            </div>
            <div class="submit">
                <button class="appBtn">Войти</button>
                <p>или нажмите <b>enter</b></p>
            </div>
        </form>

        
    </main>
    <!-- <footer>
        <p>справка контакты чето важное лалала</p>
        <p>
            <a href=""><img src="inst.png" ></a>
            <a href="https://vk.com/akovalinskaya"><img src="vk.png"></a>
        </p>
    </footer> -->
	</div>
</body>
</html>