<?php
	function debug($msg) {
		echo "<p>". $msg ."</p>";
	}

	$dbh = new PDO('mysql:host=localhost;dbname=nomnomcalc', "root", "", array(PDO::ATTR_PERSISTENT => true));

	if(isset($_POST["signUp"])) {
		$name = $_POST["name"];
		$login = $_POST["login"];
		$pass1 = $_POST["pass1"];
		$pass2 = $_POST["pass2"];
		$validMsg = "";
		//валидация имени
		if(strlen($name) < 3) {
			$validMsg = "Слишком короткое имя"; 
		}

		//валидация логина
		if($validMsg == "") {
			// Проверка на разрешённые символы (a-z, A-Z, 0-9)
			if (!preg_match('/^[a-zA-Z0-9]+$/', $login)) {
				$validMsg = "Логин должен состоять только из латиницы или цифр";
			} else {
				// Проверка длины (3-50 символов)
				if (strlen($login) < 3 || strlen($login) > 50) {
					$validMsg = "Слишком короткий логин"; 
				} 
			}
		}

		//валидация пароля
		if($validMsg == "") {
			if(strlen($pass1) < 3) {
				$validMsg = "Слишком короткий пароль";
			} else {
				if (!preg_match('/^[a-zA-Z0-9]+$/', $pass1)) {
					$validMsg = "Пароль должен состоять только из латиницы или цифр";
				} else {
					if($pass1 != $pass2) {
						$validMsg = "Пароли не совпадают";
					}
				}
			}
		}

		//создание пользователя
		if($validMsg == "") {
			$stmtGetUser = $dbh->prepare("SELECT id FROM users WHERE login = :login");
			$stmtGetUser->execute([':login' => $login]);
			$user = $stmtGetUser->fetch(PDO::FETCH_ASSOC);
			if($user == false) {
				//создаём пользователя
				try {
					$stmtInserUser = $dbh->prepare("INSERT INTO users (name, login, password) VALUES (:name, :login, :pass)");
					$stmtInserUser->execute([
						':name' => $name,
						':login' => $login,
						':pass' => password_hash($pass1, PASSWORD_DEFAULT)
					]);//password_verify(user, db)
						$resultMsg = "Регистрация успеша!<br>Вы можете войти по форме ниже.";
				} catch(PDOException $e) {
					$validMsg = "Ошибка: " . $e->getMessage();
				}

				if(stmtInserUser == ture) {
					$resultMsg = "Регистрация успеша!<br>Вы можете войти по форме ниже.";
				}
			} else {
				$validMsg = "Пользователь с таким логином уже существует";
			}

		}
	}

	if(isset($_POST["signIn"])) {
		echo "signIn";
	}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
	<title>Ешь и считай</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!--roboto-->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Righteous&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	<!--styles-->
	<link rel="stylesheet" type="text/css" href="styles/style.css">
</head>
<body>
	<?php 
		if(isset($_COOKIE["user"]) == true) {
			echo "пользователь есть";
		} else {
			include("html/no_user.html");
		}
	?>
	<script src="scripts/script.js"></script>
</body>
</html>