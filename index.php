<?php 
	require "includes/connection.php";

	$link = mysqli_connect($host, $user, $password, $database) 
        	or die("Ошибка " . mysqli_error($link));
	if(isset($_POST["login"]) && isset($_POST["password"]))
	{
		$login = $_POST["login"];
		$userpassword = $_POST["password"];
        $query = "SELECT * FROM users WHERE login = '$login' AND password = '$userpassword'";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
        $rows = mysqli_num_rows($result);
        if ($rows == 1) {
        	session_start();
        	$_SESSION['login']=$login;
            $_SESSION['password']=$userpassword;
            header('Location:first.php');
                exit();
        }
        else 
		{
    	echo "ERROR";
    	}
	}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Repair</title>
</head>
<body>
	<main class="mainpage">
		<form action="index.php" class="mainform" method="POST">
			<div class = "logocontainer">
				<img src="icons/logo.png" alt="" class="logo" >
			</div>

			<div class="authform">
				<input type="text" name="login" placeholder="Логин" required>
				<input type="password" name="password" placeholder="Пароль" required>
				<button type="submit">→</button>
			</div>
		</form>
	</main>
</body>
</html>
