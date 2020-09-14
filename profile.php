<?php 
	session_start();
	$bd = new \PDO('mysql:host=verif; dbname=project1;',     'Forphp',    'Php12');
	$bd->exec('SET NAMES UTF8');
	$stm = $bd->query("SELECT * FROM `users` WHERE `login` = '" . $_SESSION["user"] . "'");
		if ($stm === FALSE || $stm->rowCount()==0)
			{
			readfile("error.html");
			exit;
			}
		$profile = $stm->fetch();
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="style1.css">
    <title>Профиль</title>
  </head>
  <body>
    <section id="overlay">
      <hr>
	  <h1><?= "Здравствуйте " . $profile["name"] . " !";?></h1>
     <form action="index.php" method="POST">
				<h2>Изменить личные данные</h2>
                
		<section class="pass">
          <label for="pass">Изменить Пароль</label>
          <input type="password" name="pass" id="pass" pattern="[A-Za-z \-0-9]+" minlength="6" maxlength="20">
        </section>
        <hr>
				
		<section class="Familia">
          <p>
          <label for="name">Изменить Имя</label>
          <input type="text" name="name" id="name" pattern="[А-ЯA-Z][а-яa-z]+" required placeholder="Василий" value="<?= $profile["name"];?>"><span></span>
        </p>

        <p>
          <label for="second_name">Изменить Фамилию</label>
          <input type="text" name="second_name" id="second_name" pattern="[А-ЯA-Z][а-яa-z]+" required placeholder="Васильев" value="<?= $profile["second_name"];?>"><span></span>
        </p>

        <p>
          <label for="patronymic">Изменить Отчество</label>
          <input type="text" name="patronymic" id="patronymic" pattern="[А-ЯA-Z][а-яa-z]+" placeholder="Иванович" value="<?= $profile["patronymic"];?>"><span></span>
        </p>
        </section>
        <hr>
		
		<input type="hidden" value="<?= $_SESSION["user"];?>" name="login">
		<input type="hidden" value="profile_change" name="avtorization">
		
		<section class="submission">
          <input type="submit" value="Подтвердить">
        </section>
	
	</form>
    </section>
	
	<form action="index.php" method="POST">
	<input type="hidden" value="<?= $_SESSION["user"];?>" name="login">
	<input type="hidden" value="exit" name="avtorization">
		<section class="submission">
          <input type="submit" value="Выход">
		</section>
	</form>
  </body>
</html>