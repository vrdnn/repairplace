<?php 
	require "includes/connection.php";
	session_start();

	$link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));
    $query = "SELECT * FROM orders";
    if (isset($_POST['finished'])) {
    	   $query = "SELECT * FROM orders WHERE orderstatus = 'Завершено'";
    }
    elseif (isset($_POST['active'])) {
    	$query = "SELECT * FROM orders WHERE orderstatus = 'В работе'";
    }
    elseif (isset($_POST['all'])) {
    	$query = "SELECT * FROM orders";
    }

    $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
    $rows = mysqli_num_rows($result);
    $repair_id = array();
    $repair_date = array();
    $repair_descript = array();
    $repair_price = array();
    $repair_paystatus = array();
    $repair_orderstatus = array();

    for ($i=0; $i < $rows; $i++) { 
    	$row = mysqli_fetch_row($result);
    	$repair_id[$i] = $row[0];
    	$repair_date[$i] = $row[1];
    	$repair_descript[$i] = $row[2];
    	$repair_price[$i] = $row[3];
    	$repair_paystatus[$i] = $row[4];
    	$repair_orderstatus[$i] = $row[5];
    }
    
    if (isset($_POST['todaydate']) && isset($_POST['descript']) && isset($_POST['price'])) {
    	$todaydate=htmlentities(mysqli_real_escape_string($link,$_POST['todaydate']));
    	$descript=htmlentities(mysqli_real_escape_string($link,$_POST['descript']));
    	$price=htmlentities(mysqli_real_escape_string($link,$_POST['price']));

    	if (isset($_POST['checking']) && $_POST['checking'] == 'Yes') {
    		$checking=htmlentities(mysqli_real_escape_string($link,"Оплачено"));
    	}
    	else {
    		$checking=htmlentities(mysqli_real_escape_string($link,"Не оплачено"));
    	}

    	$query="INSERT INTO orders VALUES(NULL,'$todaydate','$descript','$price','$checking','В работе')";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

        mysqli_close($link);
        header('Location: first.php');
    }

    if (isset($_POST['delorder'])) {
    	$orderid = $_POST['delorder'];
    	$query="DELETE FROM orders WHERE id = $orderid";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

        mysqli_close($link);
        header('Location: first.php');
    }

    if (isset($_POST['endorder'])) {
    	$endorderid = $_POST['endorder'];
    	$query="UPDATE orders SET orderstatus='Завершено' WHERE id = $endorderid";
        $result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

        mysqli_close($link);
        header('Location: first.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="style.css">
	<title>Repair</title>
</head>
<body>
	<div class = first>
		<header class="page-header">
			<div>
				<img src="icons/logo.png" width="168" height="57">
			</div>
			<div class="indexmenu">
				<p class = "login"><?php echo $_SESSION["login"]?></p>
				<img src="icons/avatar.png" width="60" height="60" class="avatar">
				<a href = "logout.php"><img src="icons/exit.png" width="25" height="25" class="arrownav"></a>
			</div>
		</header>
		<main class="mainindex">
			<section class="orders">
				<p>Заказы <font color="#A9A9A9">(<?php echo $rows ?>)</font></p>
			</section>
			<section class="sorting">
				<button name="all" form="all" type="submit">Все</button>
				<button name="active" form="active" type="submit">Активные</button>
				<button name="finished" form="finished" type="submit">Завершенные</button>
				<button id="btnend">Завершить</button>
				<button id="btndel">Удалить</button>
				<button id="myBtn">Добавить</button>
				<div id="mypopup" class="popup">
					<div class="popup-content">
						<div class="popup-header">
							<h2>Добавление заказа</h2>
							<span class="close">&times;</span>
						</div>
						<form class="popup-form" method = "POST" name="add">
							<input type="datetime-local" placeholder="Дата" name="todaydate">
							<textarea placeholder="Описание заказа" name="descript"></textarea>
							<div class="pricecheck">
								<input type="text" placeholder="Стоимость" name="price">
								<input type="checkbox" name="checking" value="Yes">
								<span> Оплата</span>
							</div>
							<button type="submit" name="formSubmit">Добавить</button>
						</form>
					</div>
				</div>
				<div id="delpopup" class="popup">
					<div class="popup-content">
						<div class="popup-header">
							<h2>Удаление заказа</h2>
							<span id="closedel" class="close">&times;</span>
						</div>
						<form class="popup-form" method = "POST" name="del">
								<input type="text" placeholder="Введите номер заказа" name="delorder">
							<button type="submit" name="delsub">Удалить</button>
						</form>
					</div>
				</div>
				<div id="endpopup" class="popup">
					<div class="popup-content">
						<div class="popup-header">
							<h2>Завершение заказа</h2>
							<span id="closeend" class="close">&times;</span>
						</div>
						<form class="popup-form" method = "POST" name="end">
								<input type="text" placeholder="Введите номер заказа" name="endorder">
							<button type="submit" name="endsub">Завершить</button>
						</form>
					</div>
				</div>
			</section>

			<section class="table">
				<table>
					<tr>
						<th>Номер заказа</th>
						<th>Дата заказа</th>
						<th>Описание заказа</th>
						<th>Стоимость заказа</th>
						<th>Статус оплаты</th>
						<th>Статус заказа</th>
					</tr>
					<?php 
						for ($i=0; $i < $rows; $i++) { 
							?>
						<tr>
							<td align="center"><?php echo $repair_id[$i]?></td>
							<td align="center"><?php echo $repair_date[$i]?></td>
							<td align="center"><?php echo $repair_descript[$i]?></td>
							<td align="center"><?php echo $repair_price[$i]?></td>
							<?php if ($repair_paystatus[$i] == "Оплачено") { ?>
								<td align="center" style="color: #32CD32"><strong><?php echo $repair_paystatus[$i]?></strong></td>
							<?php } else {?> <td align="center" style="color: #DC143C"><strong><?php echo $repair_paystatus[$i]?></strong></td> <?php }?>
							<td align="center"><?php echo $repair_orderstatus[$i]?></td>
						</tr>
					<?php } ?>
				</table>
			</section>
		</main>
	</div>
	<script>
		let popup = document.getElementById('mypopup'),
			popupToggle = document.getElementById('myBtn'),
			popupClose = document.querySelector('.close');

			popupToggle.onclick = function() {
				popup.style.display="block";
			};

			popupClose.onclick = function () {
				popup.style.display="none";
			}

			window.onclick = function (e) {
				if(e.target == popup) {
					popup.style.display="none";
				}
			}

		let popupdel = document.getElementById('delpopup'),
			popupdelToggle = document.getElementById('btndel'),
			popupdelClose = document.getElementById('closedel');

			popupdelToggle.onclick = function() {
				popupdel.style.display="block";
			};

			popupdelClose.onclick = function () {
				popupdel.style.display="none";
			}

			window.onclick = function (event) {
				if(event.target == popupdel) {
					popupdel.style.display="none";
				}
			}

		let popupend = document.getElementById('endpopup'),
			popupendToggle = document.getElementById('btnend'),
			popupendClose = document.getElementById('closeend');

			popupendToggle.onclick = function() {
				popupend.style.display="block";
			};

			popupendClose.onclick = function () {
				popupend.style.display="none";
			}

			window.onclick = function (event) {
				if(event.target == popupend) {
					popupend.style.display="none";
				}
			}
	</script>
	<form id="all" class="mainform" method="POST"></form>
	<form id="active" class="mainform" method="POST"></form>
	<form id="finished" class="mainform" method="POST"></form>
</body>
</html>