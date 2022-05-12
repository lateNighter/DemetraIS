<div class="dashboard_sidebar" id="dashboard_sidebar">
	<div class="dashboard_sidebar_user">
		<span><?= $user['name'] ?></span>
	</div>
	<div class="dashboard_sidebar_menus">
		<ul class="dashboard_menu_lists">
			<li>
				<a href="./dashboard.php" ><i class="fa fa-paw" aria-hidden="true"></i> <span class="menuText">Аптека</span></a>
			</li>
			<li>
				<a href="./drug-add.php"><i class="fa fa-flask" aria-hidden="true"></i> <span class="menuText">Вакцины</span></a>
			</li>
			<li class="menuActive">
				<a href="./room.php"><i class="fa fa-home" aria-hidden="true"></i> <span class="menuText">Помещение</span></a>
			</li>
			<li>
				<a href="./fridge.php"><i class="fa fa-snowflake-o" ></i> <span class="menuText">Холодильник</span></a>
			</li>
			<li>
				<a href="./drug-add.php"><i class="fa fa-leaf" aria-hidden="true"></i> <span class="menuText">Препараты</span></a>
			</li>
		</ul>
	</div>
</div>