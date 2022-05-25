<?php
	// Start the session.
	session_start();
	if(!isset($_SESSION['user'])) header('location: index.php');
	$user = $_SESSION['user'];
	
	$drugs = include('database/show-drugs.php');
	// $regs = include('database/show-pharm-reg.php');
	// $hists = include('database/show-pharm-hist.php');
	$units = array('флак', 'шт', 'банка', 'ампул', 'пач', 'кг', 'упак', 'балон', 'д', 'кор', 'л', 'мл');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Деметра ИС</title>
	<link rel="stylesheet" type="text/css" href="css/login.css">
	<link rel="icon" href="images/cow.png">
	<!-- <script src="https://use.fontawesome.com/0c7a3095b5.js"></script> -->
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/css/bootstrap-dialog.min.css" integrity="sha512-PvZCtvQ6xGBLWHcXnyHD67NTP+a+bNrToMsIdX/NUqhw+npjLDhlMZ/PhSHZN4s9NdmuumcxKHQqbHlGVqc8ow==" crossorigin="anonymous" /> -->
	<link rel="stylesheet" href="css/bootstrap/bootstrap-dialog.min.css">
	<link rel="stylesheet" href="css/bootstrap/bootstrap.min.css">
</head>
<body>
	<header>
        <h1>Деметра ИС</h1>  
		<a href="database/logout.php" id="logoutBtn"><i class="fa fa-sign-out" aria-hidden="true"></i> Выход</a>
    </header>
	<div id="dashboardMainContainer">
		<?php include('partials/app-sidebar.php') ?>
		<div class="dasboard_content_container" id="dasboard_content_container">
			<div class="dashboard_content">
				<div class="dashboard_content_main">
					<div class="tabs">
						<div class="tabs__head">
							<div class="tabs__toggle is-active">
								<span class="tabs__name">Журнал</span>
							</div>
							<div class="tabs__toggle">
								<span class="tabs__name">История</span>
							</div>
							<div class="tabs__toggle">
								<span class="tabs__name">Акт списания</span>
							</div>
						</div>
						<div class="tabs__body">
							<div class="tabs__content is-active">
								<div class="row">
									<div class="column column-5">
										<h1 class="section_header"><i class="fa fa-plus"></i> Добавить операцию</h1>
										<div id="drugAddFormContainer">						
											<form action="database/add-pharm-reg.php" method="POST" class="appForm">
												<div class="appFormInputContainer">
													<label>Название препарата</label>
													<input class="appFormInput" list="drugs" id="drug_name" name="drug_name" required>
													<datalist id="drugs">
														<?php foreach($drugs as $index => $drug){ ?>
															<option><?= $drug['drug_name'] ?></option>
														<?php } ?>
													</datalist>
												</div>
												<div class="appFormInputContainer">
													<label>Ед измерения</label>
													<input class="appFormInput" list="units" id="unit" name="unit" required>
													<datalist id="units">
														<?php foreach($units as $unit){ ?>
															<option><?= $unit ?></option>
														<?php } ?>
													</datalist>
												</div>
												<div class="appFormInputContainer">
													<label for="quantity">Количество</label>
													<input type="number" class="appFormInput" id="quantity" name="quantity" min="0" required/>	
												</div>
												<div class="appFormInputContainer">
													<label for="expiration">Срок годности</label>
													<input type="date" class="appFormInput" id="expiration" name="expiration"  required/>	
												</div>
												<div class="appFormInputContainer">
													<label for="serial_n">Серия</label>
													<input type="text" class="appFormInput" id="serial_n" name="serial_n"  required/>	
												</div>
												<div class="appFormInputContainer">
													<label for="note">Примечания</label>
													<input type="text" class="appFormInput" id="note" name="note" />	
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
										<h1 class="section_header"><i class="fa fa-list"></i> Журнал 
												<input type="month" class="myInput" id="datePicker" name="start" min="2021-01"></h1>
										<div class="section_content">
											<div class="drugs">
												<input type="text" id="myInput" class="myInput" onkeyup="myFunction()" placeholder="Искать по названию..">
												<table id="regTable" class="myTable">
													<thead>
														<tr>												
															<th>№</th>
															<th>Дата создания</th>					
															<th>Наименование препарата</th>
															<th>Ед измерения</th>
															<th>Кол-во</th>
															<th>Срок годности &#9650</th>
															<th>Серия</th>
															<th>Примечания</th>
															<th>Действие</th>
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>
								</div>					
							</div>
							<!-- tab 2 -->
							<div class="tabs__content">
								<div class="row">
									<div class="column">
										<h1 class="section_header"><i class="fa fa-list"></i>  
											<input type="month" class="myInput" id="datePicker1" name="start" min="2021-01">
										</h1>
										<div class="section_content">
											<div class="drugs">
												<table id="regTable1" class="myTable">
													<thead>
														<tr>												
															<th>№</th>
															<th>Дата создания</th>
															<th>Дата транзакции</th>					
															<th>Наименование препарата</th>
															<th>Приход</th>
															<th>Расход</th>
															<th>Списание ЧО</th>
															<th>Сотрудник</th>
															<!-- <th>Действие</th> -->
														</tr>
													</thead>
												</table>
											</div>
										</div>
									</div>	
								</div>
							</div>
							<!-- tab 3 -->
							<div class="tabs__content">
								<div class="row">
									<div class="column">
										<h1 class="section_header"><i class="fa fa-list"></i>  
											<input type="month" class="myInput" id="datePicker2" name="start" min="2021-01">
										</h1>
										<div class="section_content">
											<div class="drugs">
												<table id="regTable2" class="myTable">
													<thead>
														<tr>												
															<th>№</th>
															<!-- <th>Дата</th>		 -->
															<th>Наименование препарата</th>
															<th>Ед измерения</th>
															<th>Количество</th>
															<th>Примечание</th>
														</tr>
													</thead>
												</table>
												<a class="appBtn" style="float: right; margin-top: 15px; text-decoration: none;" href="javascript:print_act()"  >Печать</a> 
												<!-- target="_blank" -->
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
	</div>

<script src="js/jquery-3.6.0.min.js"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.35.4/js/bootstrap-dialog.js" integrity="sha512-AZ+KX5NScHcQKWBfRXlCtb+ckjKYLO1i10faHLPXtGacz34rhXU8KM4t77XXG/Oy9961AeLqB/5o0KTJfy2WiA==" crossorigin="anonymous"></script>
<script src="js/search.js"></script>
<script src="js/moment-with-locales.min.js"></script>

<script>
	Date.prototype.toMonthInputValue = (function() {
		var local = new Date(this);
		local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
		return local.toJSON().slice(0,7);
	});
	document.getElementById('datePicker').value = new Date().toMonthInputValue();
	document.getElementById('datePicker').max = new Date().toMonthInputValue();
	document.getElementById('datePicker1').value = new Date().toMonthInputValue();
	document.getElementById('datePicker1').max = new Date().toMonthInputValue();
	document.getElementById('datePicker2').value = new Date().toMonthInputValue();
	document.getElementById('datePicker2').max = new Date().toMonthInputValue();
</script>

<!-- <script src="js/monthPicker.js"></script> -->
<script>
var global_reg=[];
$(document).ready(function () {
	monthChange();
    function monthChange() {

        var year = $('#datePicker').val().slice(0,4); 
        var month = $('#datePicker').val().slice(-2); 
        $.ajax({

            type: "POST",
            url: "database/show-pharm-reg.php",
            data: { year1: year, month1: month },
			async: false,
            success: function (result) {
                if (result) {
					result = JSON.parse(result);
					global_reg=result;
                    $("#regTable").html('');
					var thead=$('<thead/>');
                    var tr;
                    tr = $('<tr/>');
                    tr.append("<th>№</th>");
                    tr.append("<th>Дата создания</th>");
                    tr.append("<th>Наименование препарата</th>");
                    tr.append("<th>Ед измерения</th>");
                    tr.append("<th>Кол-во</th>");
                    tr.append("<th id='thsort' data-column='expiration' data-order='desc'>Срок годности &#9650</th>");
                    tr.append("<th>Серия</th>");
                    tr.append("<th>Примечания</th>");
                    tr.append("<th>Действие</th>");
					thead.append(tr);
                    $('#regTable').append(thead);
					
					var tbody=$('<tbody/>');
					var tr;
                    for (var i in result) {
                        tr = $('<tr/>');
                        tr.append("<td>" + (Number(i)+Number(1)) + "</td>");
                        tr.append("<td class='ctime'>" + new Date(result[i].date).toLocaleDateString() + "</td>");
                        tr.append("<td class='drug_name'>" + result[i].drug_name + "</td>");
                        tr.append("<td>" + result[i].unit + "</td>");
                        tr.append("<td class='amount'>" + result[i].amount + "</td>");
                        tr.append("<td>" + new Date(result[i].expiration).toLocaleDateString() + "</td>");
                        tr.append("<td>" + result[i].serial_n + "</td>");
                        tr.append("<td>" + result[i].note + "</td>");
						tr.append('<td class="actions"><a href=""> <i class="fa fa-pencil" id="updatereg" data-regid=' + result[i].id + 'data-regdata' + result[i].date +'></i> </a></td>');
                        $(tbody).append(tr);

                    }
					$('#regTable').append(tbody);

					$('#thsort').on('click', SortExp);
                }
            },

            error: function() {
                alert('failure');
            }

        })

    }
    $('#datePicker').on('change', monthChange);
});

// sort by expiration
function SortExp(){
	let count = 0;
	var table, tr, td, i, txtValue;
	table = document.getElementById("regTable");
	tr = table.getElementsByTagName("tr");
	var arr = [];
	if (global_reg){
		arr = global_reg;
	}
	var column = $('#thsort').data('column')
	var order = $('#thsort').data('order')
	var text = $('#thsort').html()
	text = text.substring(0, text.length - 1)
	if(order == 'desc'){
		$('#thsort').data('order', "asc")
		arr = arr.sort((a,b) => a[column] > b[column] ? 1 : -1)
		text += '&#9660'
	}else{
		$('#thsort').data('order', "desc")
		arr = arr.sort((a,b) => a[column] < b[column] ? 1 : -1)
		text += '&#9650'
	}
	$('#thsort').html(text)

	$("#regTable tbody").html('');
	var tbody=$('<tbody/>');
	var tr;
	for (var i in arr) {
		tr = $('<tr/>');
		tr.append("<td>" + (Number(i)+Number(1)) + "</td>");
		tr.append("<td class='ctime'>" + new Date(arr[i].date).toLocaleDateString() + "</td>");
		tr.append("<td class='drug_name'>" + arr[i].drug_name + "</td>");
		tr.append("<td>" + arr[i].unit + "</td>");
		tr.append("<td class='amount'>" + arr[i].amount + "</td>");
		tr.append("<td>" + new Date(arr[i].expiration).toLocaleDateString() + "</td>");
		tr.append("<td>" + arr[i].serial_n + "</td>");
		tr.append("<td>" + arr[i].note + "</td>");
		tr.append('<td class="actions"><a href=""> <i class="fa fa-pencil" id="updatereg" data-regid=' + arr[i].id + 'data-regdata' + arr[i].date +'></i> </a></td>');
		$(tbody).append(tr);

	}
	$('#regTable').append(tbody);


}
$('#thsort').on('click', SortExp);
</script>

<script>
$(document).ready(function () {
	monthChange1();
    function monthChange1() {

        var year = $('#datePicker1').val().slice(0,4); 
        var month = $('#datePicker1').val().slice(-2); 
        $.ajax({

            type: "POST",
            url: "database/show-pharm-hist.php",
            data: { year1: year, month1: month },
			async: false,
            success: function (result) {
                if (result) {
					result = JSON.parse(result);
                    $("#regTable1").html('');
					var thead=$('<thead/>');
                    var tr;
                    tr = $('<tr/>');
                    tr.append("<th>№</th>");
                    tr.append("<th>Дата создания</th>");
                    tr.append("<th>Дата транзакции</th>");
                    tr.append("<th>Наименование препарата</th>");
                    tr.append("<th>Приход</th>");
                    tr.append("<th>Расход</th>");
                    tr.append("<th>Списание ЧО</th>");
                    tr.append("<th>Сотрудник</th>");
                    // tr.append("<th>Действие</th>");
					thead.append(tr);
                    $('#regTable1').append(thead);
                    for (var i in result) {
                        tr = $('<tr/>');
                        tr.append("<td>" + (Number(i)+Number(1)) + "</td>");
                        tr.append("<td>" + new Date(result[i].creat_d).toLocaleDateString() + "</td>");
                        tr.append("<td>" + new Date(result[i].trans_d).toLocaleDateString() + "</td>");
                        tr.append("<td class='drug_name'>" + result[i].drug_name + "</td>");
                        tr.append("<td>" + result[i].income + "</td>");
                        tr.append("<td>" + result[i].expense + "</td>");
                        tr.append("<td>" + result[i].emergency + "</td>");
                        tr.append("<td>" + result[i].name + "</td>");
						// tr.append('<td class="actions"><a href=""> <i class="fa fa-pencil" id="updatedrug" data-histid=' + i +' data-dname=' + result[i].drug_name +'></i> </a></td>');
                        $('#regTable1').append(tr);

                    }
                }
            },

            error: function() {
                alert('failure');
            }

        })

    }
    $('#datePicker1').on('change', monthChange1);
});
</script>
<script>
$(document).ready(function () {
	monthChange2();
    function monthChange2() {

        var year = $('#datePicker2').val().slice(0,4); 
        var month = $('#datePicker2').val().slice(-2); 
        $.ajax({

            type: "POST",
            url: "database/show-pharm-act.php",
            data: { year1: year, month1: month },
			async: false,
            success: function (result) {
                if (result) {
					result = JSON.parse(result);
                    $("#regTable2").html('');
					var thead=$('<thead/>');
                    var tr;
                    tr = $('<tr/>');
                    tr.append("<th>№</th>");
                    // tr.append("<th>Дата</th>");
                    tr.append("<th>Наименование препарата</th>");
                    tr.append("<th>Ед измерения</th>");
                    tr.append("<th>Количество</th>");
                    tr.append("<th>Примечание</th>");
					thead.append(tr);
                    $('#regTable2').append(thead);
                    for (var i in result) {
                        tr = $('<tr/>');
                        tr.append("<td>" + (Number(i)+Number(1)) + "</td>");
                        // tr.append("<td>" + new Date(result[i].date).toLocaleDateString() + "</td>");
                        tr.append("<td class='drug_name'>" + result[i].drug_name + "</td>");
                        tr.append("<td>" + result[i].unit + "</td>");
                        tr.append("<td>" + result[i].amount + "</td>");
                        tr.append("<td>" + result[i].note + "</td>");
                        $('#regTable2').append(tr);
                    }
                }
            },

            error: function() {
                alert('failure');
            }

        })

    }
    $('#datePicker2').on('change', monthChange2);
});
</script>

<!-- search by drug name -->
<script>
	function myFunction() {
	let count = 0;
	var input, filter, table, tr, td, i, txtValue;
	input = document.getElementById("myInput");
	filter = input.value.toUpperCase();
	table = document.getElementById("regTable");
	tr = table.getElementsByTagName("tr");

	for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[2];
		if (td) {
		txtValue = td.textContent || td.innerText;
		if (txtValue.toUpperCase().indexOf(filter) > -1) {
			tr[i].style.display = "";
			count+=1;
		} else {
			tr[i].style.display = "none";
		}
		}
	}
	}
</script>


<!-- update pharm reg -->
<script>
	function script(){


		this.initialize = function(){
			this.registerEvents();
		},

		this.registerEvents = function(){
			document.addEventListener('click', function(e){
				targetElement = e.target;

				if(targetElement.id=='updatereg'){
					e.preventDefault(); 
					drugName = targetElement.closest('tr').querySelector('td.drug_name').innerHTML;
					amount = targetElement.closest('tr').querySelector('td.amount').innerHTML;
					regId = targetElement.dataset.regid;
					ctime = targetElement.dataset.regdata;
					BootstrapDialog.confirm({
						title: 'Update ' + drugName,
						message: '<form>\
						  <div class="form-group" style="display: flex; flex-direction: column;">\
						    <label for="income">Приход:</label>\
						    <input type="number" class="form-control" id="income" min="0">\
							<label for="expense">Расход:</label>\
						    <input type="number" class="form-control" id="expense" min="0">\
							<label for="emergency">Списание:</label>\
						    <input type="number" class="form-control" id="emergency" min="0">\
						  </div>\
						</form>',
						callback: function(isUpdate){
							if(isUpdate){ 
								$.ajax({
									method: 'POST',
									data: {
										regId: regId,
										ctime: ctime,
										d_name: drugName,
										amount: amount,
										income: document.getElementById('income').value,
										expense: document.getElementById('expense').value,
										emergency: document.getElementById('emergency').value,
									},
									url: 'database/update-pharm-reg.php',
									dataType: 'json',
									success: function(data){
										if(data.success){
											location.reload();
										} 
										else{
											alert(data.message);
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

<script>
	function print_act(){
		// console.log(document.getElementById("regTable2").innerHTML);
		$.ajax({
			method: 'POST',
			data: {
				table: document.getElementById("regTable2").innerHTML,
			},
			url: 'partials/print.php',
			dataType: 'json',
			success: function(data){
				// if(data=='ok'){
					// location.reload();
				// } 
				console.log(data.message);
				window.open('partials/final_print.php', '_blank');
			}
		});
	}
</script>
</body>
</html>