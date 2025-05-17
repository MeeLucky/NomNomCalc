<?php
	function debug($msg) {
		echo "<p>". $msg ."</p>";
	}
	function dump($arr) {
		echo "<pre>";
		var_dump($arr);
		echo "</pre>";
	}
	
	$dbh = new PDO('mysql:host=localhost;dbname=nomnomcalc', "root", "", array(PDO::ATTR_PERSISTENT => true));

	include("php/signUpIn.php");
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
	<link rel="stylesheet" type="text/css" href="styles/header.css">
</head>
<body>
	<?php 
		if(isset($_COOKIE["user_id"]) == true) {
			include("html/header.html");
			switch ($_GET["page"]) {
				case "journal":
					include("html/journal.php");
					break;
				case "":
					include("html/journal.php");
					break;
				case "products":
					include("html/soon.html");
					break;
				case "dictionory":
					include("html/soon.html");
					break;
				case "calculate":
					include("html/soon.html");
					break;
				default:
					include("html/404.html");
			}
		} else {
			include("html/no_user.html");
		}
	?>
	<script src="scripts/script.js"></script>
</body>
</html>