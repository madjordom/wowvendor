<!doctype html>
	<html lang="ru">
	<head>
		<title>Тестовое задание для разработчика WowVendor</title>
	</head>
	<body>
		<p>Тестовое задание для разработчика WowVendor: реализовано "на коленке". При желании и наличии времени могу реализовать с использованием простой MVC-моделью, PDO, Composer, Миграции, Ajax, подключить Bottstrap 4.</p>
		<?php
		$host = 'localhost';
		$db_name = 'wowvendor_test';
		$user = 'wowvendor_test_user';
		$password = 'Ku33kjfDkf93R2xv4_iu4';
		$link = mysqli_connect($host, $user, $password, $db_name);
		if (!$link) {echo 'Не могу соединиться с Базой данных. Код ошибки: ' . mysqli_connect_errno() . ', ошибка: ' . mysqli_connect_error(); exit;}
		?>
		<h1>Панель управления пользователями</h1>
		<h2>Добавить роль</h2>
		<form action="" method="post">
			<table>
				<tr>
					<td><input type="text" name="rolename" required></td>
					<td><input type="submit" name = "add_user_role" value="Добавить"></td>
				</tr>
			</table>
		</form>
		<?php
		if (isset($_POST["add_user_role"]) and isset($_POST["rolename"])) {
			$sql = mysqli_query($link, "INSERT INTO `user_role` (`rolename`) VALUES ('{$_POST['rolename']}')");
			if ($sql) {echo '<p style = "color:red;">Данные роли добавлены.</p>';} else {echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';}
		} 
		?>
		<h2>Добавить пользователя</h2>
		<form action="" method="post">
			<table>
				<tr>
					<td>
						<input type="text" name="username" required>
					</td>
					<td>
						<select name="roleid" required>
							<option disabled selected value="">Выберите роль</option>
							<?php
							$result = mysqli_query($link, "SELECT id, rolename FROM user_role");
							while ($row = mysqli_fetch_array($result)) {
								echo '<option value="'.$row['id'].'">'.$row['rolename'].'</option>';
							}
							?>
						</select>
					</td>
					<td>
						<input type="submit" name = "add_user" value="Добавить">
					</td>
				</tr>
			</table>
		</form>
		<?php 
		if ($_POST["roleid"] !='' and isset($_POST["add_user"]) and isset($_POST["username"]) and isset($_POST["roleid"])) {
			$sql = mysqli_query($link, "INSERT INTO `user` (`username`, `role_id`) VALUES ('{$_POST['username']}', '{$_POST['roleid']}')");
		if ($sql) {echo '<p style = "color:red;">Данные пользователя добавлены.</p>';} else {echo '<p>Произошла ошибка: ' . mysqli_error($link) . '</p>';}
		} 
		?>
		<h2>Список пользователей</h2>
		<table>
			<tr>
				<th>Имя пользователя</th>
				<th>Роль</th>
			</tr>
		<?php
		$result2 = mysqli_query($link, "SELECT u.username, r.rolename FROM user u LEFT JOIN user_role r ON u.role_id = r.id");
		while ($row2 = mysqli_fetch_array($result2)) {?>
			<tr>
				<td><?php echo $row2['username']; ?></td>
				<td><?php echo $row2['rolename']; ?></td>
			</tr>
		<?php
		}
		?>
		</table>
	</body>
</html>