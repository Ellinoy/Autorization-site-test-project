<?php
	session_start();
    $action = (string)$_POST["autorization"];
	$bd = new \PDO('mysql:host=verif; dbname=project1;',     'Forphp',    'Php12');
	$bd->exec('SET NAMES UTF8');
	if($action === NULL || $action === "") //проверяем есть ли данные авторизации пользователя. Если нет, отправляем на авторизацию, если да отправляем его дальше
	{
		if($_SESSION["user"] !== NULL)
			{
			header ("Location: /profile.php");
			exit;
			}
		readfile("autorization.html");
		exit;
	}
	switch ($action) //проверяем данные поступившие от пользователя
	{
		case "reg":
			readfile("regist.html");
			break;
		case "autorization": //проверяем авторизуется ли пользователь
			$login = (string)$_POST["login"];
			$password = (string)$_POST["pass"];
			$stm = $bd->query("SELECT * FROM `users` WHERE `login` = '" . $login . "'");
				if ($stm === FALSE || $stm->rowCount()==0)
				{
				readfile("error.html");
				exit;
				}
				$pasprof = $stm->fetch();
					if ($pasprof["pass"] != $password)
						{
						readfile("error.html");
						exit;
						}
			$_SESSION["user"] = $login;
			header ("Location: /profile.php");
			break;
		case "registration": // проверяем данные регистрационной формы, если пользователь регистрируется
			$login = (string)$_POST["login"];
			$password = (string)$_POST["pass"];
			$email = (string)$_POST["email"];
			$name = (string)$_POST["name"];
			$second_name = (string)$_POST["second_name"];
			$patronymic = (string)$_POST["patronymic"];
			$stm = $bd->query("SELECT * FROM `users` WHERE `login` = '" . $login . "'");
			if ($stm === FALSE )
				{
				die ("Ошибка подключения, попробуйте позднее.");
				}
			if ($stm->rowCount() > 0)
				{
				readfile("regerror.html");
				exit;
				}
			$bd->query("INSERT users VALUES(NULL, '$login', '$password', '$email', '$name', '$second_name', '$patronymic')");
			$_SESSION["user"] = $login;
			readfile("profile.php");
			break;
		case "profile_change": //если пользователь успешно авторизовался даем ему возможность изменять свой профиль
			$login = (string)$_POST["login"];
			$password = (string)$_POST["pass"];
			$name = (string)$_POST["name"];
			$second_name = (string)$_POST["second_name"];
			$patronymic = (string)$_POST["patronymic"];
			$stm = $bd->query("SELECT * FROM `users` WHERE `login` = '" . $login . "'");
			if ($stm === FALSE )
				{
				die ("Ошибка подключения, попробуйте позднее.");
				}
			$query = "UPDATE users SET `name` = '$name', `second_name` = '$second_name', `patronymic` = '$patronymic'";
			if ($password !== "") $query .= ", `pass` = '$password'";
			$query .= " WHERE `login` = '$login'";
			$bd->query($query);
			$_SESSION["user"] = $login;
			header ("Location: /profile.php");
			break;
		case "exit": //звершаем сессию когда пользователь выходит из профиля
			$_SESSION["user"] = NULL;
			readfile("autorization.html");
			break;
	}
	?>
