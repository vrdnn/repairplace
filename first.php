<?php 
	require "includes/connection.php";

	$link = mysqli_connect($host, $user, $password, $database) 
        or die("Ошибка " . mysqli_error($link));
    $query = "SELECT * FROM orders";

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

    // for ($i=0; $i < $rows ; $i++) { 
    // 	echo $repair_id[i]."  ".$repair_date[i]."  ".$repair_descript[i]."  ".$repair_price[i]."  ".$repair_paystatus[i]."  ".$repair_orderstatus[i];
    // 	echo "<br>";
    // }
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
	<header class="page-header">
		<div>
			<img src="icons/logo.png" width="168" height="57">
		</div>
		<div class="indexmenu">
			<p>Вартан</p>
			<img src="icons/avatar.png" width="60" height="60" class="avatar">
			<img src="icons/arrow.png" width="25" height="25" class="arrownav">
		</div>
	</header>
	<main class="mainindex">
		<section class="orders">
			<p>Заказы <font color="#A9A9A9">(3)</font><p>
		</section>
		<section class="sorting">
			<button>Все</button>
			<button>Активные</button>
			<button>Завершенные</button>
			<button>Удаленные</button>
			<button>Добавить</button>
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
</body>
</html>