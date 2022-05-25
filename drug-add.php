<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: index.php');
	$_SESSION['table'] = 'drugs';
	// $_SESSION['table1'] = 'vaccines';
	$user = $_SESSION['user'];
	$drugs = include('database/show-drugs.php');
	$vacs = include('database/show-vac.php');
	// $is_vac = false;
	// if(isset($_SESSION['response'])){
		// $is_vac = $_COOKIE['isvac'];
	// }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Деметра ИС</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" href="images/cow.png">
	<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" />
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
</head>
<body>
	<header>
        <h1>Деметра ИС</h1>  
		<a href="database/logout.php" id="logoutBtn"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a>
    </header>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar4.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div class="dashboard_content">
			<div class="tabs">
					<div class="tabs__head">
						
									<div class="tabs__toggle <?= $is_vac ? '' : 'is-active' ?>" >
										
						<!-- <div class="tabs__toggle is-active"> -->
							<span class="tabs__name">Аптека</span>
						</div>
						<!-- <div class="tabs__toggle"> -->
						
									<div class="tabs__toggle <?= $is_vac ? 'is-active' : '' ?>" >
										
							<span class="tabs__name">Вакцины</span>
						</div>
					</div>
					<div class="tabs__body">
						
									<div class="tabs__content <?= $is_vac ? '' : 'is-active' ?>" >
										
							<div class="row">
								<div class="column column-5">
									<h1 class="section_header"><i class="fa fa-plus"></i> Добавить препарат</h1>
									<div id="drugAddFormContainer">						
										<form action="database/add.php" method="POST" class="appForm">
											<div class="appFormInputContainer">
												<label for="drug_name">Название препарата</label>
												<input type="text" class="appFormInput" id="drug_name" name="drug_name" />	
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
									<h1 class="section_header"><i class="fa fa-list"></i> Список препаратов</h1>
									<div class="section_content">
										<div class="drugs">
											<input type="text" id="myInput" class="myInput" onkeyup="myFunction()" placeholder="Искать по названию..">
											<input type="text" class="myInput" id="datefilterfrom" data-date-split-input="true" placeholder="Добавлен после" onfocus="(this.type='date')" onblur="(this.type='text')">
											<input type="text" class="myInput" id="datefilterto" data-date-split-input="true" placeholder="Добавлен до" onfocus="(this.type='date')" onblur="(this.type='text')">
											<p id="drugCount" class="drugCount"><?= count($drugs) ?> drugs </p>
											<table id="myTable" class="myTable">
												<thead>
													<tr>												
														<th>№</th>					
														<th>Название</th>
														<th>Дата добавления</th>
														<th>Действие</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($drugs as $index => $drug){ ?>
														<tr>
															<td><?= $index + 1 ?></td>
															<td class="drug_name"><?= $drug['drug_name'] ?></td>
															<td><?= date('d.m.Y', strtotime($drug['created_at'])) ?></td>
															<td class="actions">
																<a href=""> <i class="fa fa-pencil" id="updatedrug" data-drugid="<?= $drug['id'] ?>"></i> </a>
																<a href=""> <i class="fa fa-trash" id="deletedrug" data-drugid="<?= $drug['id'] ?>" data-dname="<?= $drug['drug_name'] ?>"></i> </a>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>					
						</div>
						
								<div class="tabs__content <?= $is_vac ? 'is-active' : '' ?>" >
									
						<!-- <div class="tabs__content"> -->
						<div class="row">
								<div class="column column-5">
									<h1 class="section_header"><i class="fa fa-plus"></i> Добавить препарат</h1>
									<div id="drugAddFormContainer">						
										<form action="database/add-vac.php" method="POST" class="appForm">
											<div class="appFormInputContainer">
												<label for="drug_name">Название препарата</label>
												<input type="text" class="appFormInput" id="drug_name" name="drug_name" />	
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
									<h1 class="section_header"><i class="fa fa-list"></i> Список препаратов</h1>
									<div class="section_content">
										<div class="drugs">
											<input type="text" id="myInput1" class="myInput" onkeyup="myFunction1()" placeholder="Искать по названию..">
											<input type="text" class="myInput" id="datefilterfrom1" data-date-split-input="true" placeholder="Добавлен после" onfocus="(this.type='date')" onblur="(this.type='text')">
											<input type="text" class="myInput" id="datefilterto1" data-date-split-input="true" placeholder="Добавлен до" onfocus="(this.type='date')" onblur="(this.type='text')">
											<p id="drugCount1" class="drugCount"><?= count($vacs) ?> drugs </p>
											<table id="myTable1" class="myTable">
												<thead>
													<tr>												
														<th>№</th>					
														<th>Название</th>
														<th>Дата добавления</th>
														<th>Действие</th>
													</tr>
												</thead>
												<tbody>
													<?php foreach($vacs as $index => $drug){ ?>
														<tr>
															<td><?= $index + 1 ?></td>
															<td class="drug_name"><?= $drug['drug_name'] ?></td>
															<td><?= date('d.m.Y', strtotime($drug['created_at'])) ?></td>
															<td class="actions">
																<a href=""> <i class="fa fa-pencil" id="updatevac" data-drugid="<?= $drug['id'] ?>"></i> </a>
																<a href=""> <i class="fa fa-trash" id="deletevac" data-drugid="<?= $drug['id'] ?>" data-dname="<?= $drug['drug_name'] ?>"></i> </a>
															</td>
														</tr>
													<?php } ?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script src="js/tabs.js"></script>
			</div>
		</div>
	</div>


<script src="js/jquery-3.6.0.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous"></script>
<script src="js/search.js"></script>
<script src="js/moment-with-locales.min.js"></script>



<script>
	function script(){


		this.initialize = function(){
			this.registerEvents();
		},

		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target;
				// classList = targetElement.classList;
				
				if(targetElement.id=='deletedrug'){ //classList.contains('deletedrug')
					e.preventDefault();
					drugId = targetElement.dataset.drugid;
					dname = targetElement.dataset.dname;
					// fullName = fname + ' ' + lname;

					BootstrapDialog.confirm({ 
						type: BootstrapDialog.TYPE_DANGER,
						message: 'Are you sure to delete '+ dname +'?',
						callback: function(isDelete){
							if(isDelete){ // If user click 'Ok' button.
								$.ajax({
									method: 'POST',
									data: {
										drug_id: drugId,
										d_name: dname
									},
									url: 'database/delete-drug.php',
									dataType: 'json',
									success: function(data){
										// if(data.success){
										// 	BootstrapDialog.alert({
										// 		type: BootstrapDialog.TYPE_SUCCESS,
										// 		message: data.message,
										// 		callback: function(){
										// 			location.reload();
										// 		}
										// 	});
										// 	// location.reload();
										// } else 
										// BootstrapDialog.alert({
										// 		type: BootstrapDialog.TYPE_DANGER,
										// 		message: data.message,
										// 	});
										if(data.success){
											location.reload();
										} 
									}
								});
							}
						}
					});
				}

				if(targetElement.id=='updatedrug'){
					e.preventDefault(); // Prevent loading.;

					// Get data.
					drugName = targetElement.closest('tr').querySelector('td.drug_name').innerHTML;
					// lastName = targetElement.closest('tr').querySelector('td.lastName').innerHTML;
					// email = targetElement.closest('tr').querySelector('td.email').innerHTML;
					drugId = targetElement.dataset.drugid;


					BootstrapDialog.confirm({
						title: 'Update ' + drugName,
						message: '<form>\
						  <div class="form-group">\
						    <label for="drugName">Название препарата:</label>\
						    <input type="text" class="form-control" id="drugName" value="'+ drugName +'">\
						  </div>\
						</form>',
						callback: function(isUpdate){
							if(isUpdate){ // If user click 'Ok' button.
								$.ajax({
									method: 'POST',
									data: {
										drugId: drugId,
										d_name: document.getElementById('drugName').value,
									},
									url: 'database/update-drug.php',
									dataType: 'json',
									success: function(data){
										if(data.success){
											location.reload();
										} 
									}
								});
							}
						}
					});
				}

				//vaccines
				if(targetElement.id=='deletevac'){ 
					e.preventDefault();
					drugId = targetElement.dataset.drugid;
					dname = targetElement.dataset.dname;

					BootstrapDialog.confirm({ 
						type: BootstrapDialog.TYPE_DANGER,
						message: 'Are you sure to delete '+ dname +'?',
						callback: function(isDelete){
							if(isDelete){ 
								$.ajax({
									method: 'POST',
									data: {
										drug_id: drugId,
										d_name: dname
									},
									url: 'database/delete-vac.php',
									dataType: 'json',
									success: function(data){
										if(data.success){
											location.reload();
										} 
									}
								});
							}
						}
					});
				}

				if(targetElement.id=='updatevac'){
					e.preventDefault(); 
					drugName = targetElement.closest('tr').querySelector('td.drug_name').innerHTML;
					drugId = targetElement.dataset.drugid;
					BootstrapDialog.confirm({
						title: 'Update ' + drugName,
						message: '<form>\
						  <div class="form-group">\
						    <label for="drugName">Название препарата:</label>\
						    <input type="text" class="form-control" id="drugName" value="'+ drugName +'">\
						  </div>\
						</form>',
						callback: function(isUpdate){
							if(isUpdate){ 
								$.ajax({
									method: 'POST',
									data: {
										drugId: drugId,
										d_name: document.getElementById('drugName').value,
									},
									url: 'database/update-vac.php',
									dataType: 'json',
									success: function(data){
										if(data.success){
											location.reload();
										} 
									}
								});
							}
						}
					});
				}
			});
		}
	}	

	var script = new script;
	script.initialize();
</script>
</body>
</html>