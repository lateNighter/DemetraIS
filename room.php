<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: index.php');
	$_SESSION['table'] = 'room';
	$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Деметра ИС</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" href="images/cow.png">
	<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" /> -->
	<link rel="stylesheet" href="css/bootstrap/bootstrap-dialog.min.css">
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
	<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
	<script src="js/jquery-3.6.0.min.js"></script>

	<script src="js/moment-with-locales.min.js"></script>
	<script type="module" src="calendar/js/main1.js"></script>

	<link rel="stylesheet" href="calendar/css/calendar.css" />
	<link rel="stylesheet" href="calendar/css/style.css" />
	<link rel="stylesheet" href="calendar/css/theme.css" />
</head>
<body>
	<header>
        <h1>Деметра ИС</h1>  
		<a href="database/logout.php" id="logoutBtn"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a>
    </header>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar2.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div class="dashboard_content">
				<div class="dashboard_content_main">		
					<div class="row">
						<div class="column column-5">
							<h1 class="section_header"><i class="fa fa-plus"></i> Добавить показание</h1>
							<div id="drugAddFormContainer">						
								<form action="database/room-add.php" method="POST" class="appForm">
									<div class="appFormInputContainer">
										<label for="date">Дата</label>
										<input type="date" class="appFormInput" id="datePicker" name="date" />	
									</div>
                                    <div class="appFormInputContainer">
										<label for="temperature">Температура</label>
										<input type="text" class="appFormInput" id="temperature" name="temperature" />	
									</div>
                                    <div class="appFormInputContainer">
										<label for="humidity">Влажность</label>
										<input type="text" class="appFormInput" id="humidity" name="humidity" />	
									</div>
									<button type="submit" class="appBtn"> Добавить</button>
								</form>	
								<?php 
									if(isset($_SESSION['response'])){
										$response_message = $_SESSION['response']['message'];
										$is_success = $_SESSION['response']['success'];
								?>
									<div class="responseMessage">
										<p class="responseMessage <?= $is_success ? 'responseMessage__success' : 'responseMessage__error' ?>" >
											<?= $response_message ?>
										</p>
									</div>
								<?php unset($_SESSION['response']); }  ?>
							</div>	
						</div>
						<div class="column column-7">
							<h1 class="section_header"><i class="fa fa-list"></i> Карта контроля температурного режима и влажности</h1>
							<div id="calendar"></div>
						</div>
					</div>					
				</div>
			</div>
		</div>
	</div>
	<script src="js/bootstrap.min.js"></script>
	<script>
        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0,10);
        });
        document.getElementById('datePicker').value = new Date().toDateInputValue();
        document.getElementById('datePicker').max = new Date().toDateInputValue();
    </script>
</body>
</html>