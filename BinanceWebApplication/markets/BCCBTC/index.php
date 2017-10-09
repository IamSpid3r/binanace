<?php
	include '../../api.php';
	include 'getCoinSymbol.php';
	$serverMessage;
	$error;

	//Cancel
	if (!empty($_POST["cancelOrder"])) {
		$orderID = $_POST["cancelOrder"];
		include 'cancelOrder.php';
	}
	
	// Buy
	if( !empty($_POST["priceBuy"]) && !empty($_POST["amountBuy"] ) ) { 
		include 'buyOrder.php';
	}
	
	//SELL
	if( !empty($_POST["priceSell"]) && !empty($_POST["amountSell"] ) ) { 
		include 'sellOrder.php';
	}
	
?>

<html>

	<head>
		<title>Binance API Competition</title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../../css/bootstrap.min.css">
		<link rel="stylesheet" href="../../css/style.css"/>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../../css/font-awesome.min.css">
		<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="../../css/jquery.dataTables.min.css">
	</head>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#"><img src="../../resources/logo-en.svg" style="height:22px;"></a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="../../">Home</a></li>
			  <li class="active"><a href="../../markets.php">Markets</a></li>
			  <li><a href="../../wallet.php">Wallet</a></li>
			  <li><a href="../../account.php">Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="../update.php">Update</a></li>
			</ul>
		  </div>
		</nav>
	<body>
	
	<div class="container1" style="width: 90%;height:250px;padding: 0% 5% 0% 5%;">
		<h1><?php echo "MARKET - " . $coin . "/" . $pair;?></h1>
		<hr>
		
		<div id="graphandstats" style="width:100%;">
			
			<?php include 'depthChart.php';?>
		
			<div id="stats" style="width:30%;height: 500px;">
				<?php
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
				curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/ticker/24hr?symbol=".$symbol);
				$resultStats = curl_exec($ch);		
				$json = json_decode($resultStats);
				curl_close($ch);
				?>
				<br><br><br>
				<div class="col-md-6">
					<table class="table table-hover ">
					<thead>
					<tr>
					<th colspan="2"><img src="../../resources/<?php echo $coin;?>.png"> <?php echo $coin; ?></th>
					</tr>
					</thead>
					<tbody>
					<tr>
					<td
					<td class="text-muted">Last Price</td>
					<th id="ajax51"><?php echo $json->lastPrice; ?></th>
					</tr>
					<tr>
					<td class="text-muted">24h Change</td>
					<th id="ajax5"><?php echo $json->priceChangePercent; ?>%</th>
					</tr>
					<tr>
					<td class="text-muted">24h High</td>
					<th id="ajax7"><?php echo $json->highPrice; ?></th>
					</tr>
					<tr>
					<td class="text-muted">24h Low</td>
					<th id="ajax9"><?php echo $json->lowPrice ?></th>
					</tr>
					<tr>
					<td class="text-muted">24h Volume</td>
					<th id="ajax11"><?php echo $json->volume; ?></th>
					</tr>
					</tbody>
					</table>
				</div>
			</div>
		</div>
		<br><br><br><br><br><br><br><br>
		<div id="buyAndSell" style="width:100%; height:150px;">
			<?php include 'currentPosition.php';?>
			<div id="buy" style="float:left;padding: 0% 2% 0% 1%;">
				Available<?php echo " $pair: $pairAvailable"; ?>
				<hr>
				<form action="<?php $_PHP_SELF ?>" method="post">
				Market Order:<input type="checkbox" name="marketOrder" value="value"><br>
				Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="priceBuy" /><br>
				Amount: <input type="text" name="amountBuy" /></p>
				<input class ="buy" type="submit" name="submitBuy" value="BUY"/> 
				</form>
			</div>
			<div id="sell" style="padding: 0% 5% 0% 5%;">
				Available<?php echo " $coin: $coinAvailable"; ?>
				<hr>
				<form action="<?php $_PHP_SELF ?>" method="post">
				Market Order:<input type="checkbox" name="marketOrder" value="value1"><br>
				Price:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="priceSell" /><br>
				Amount: <input type="text" name="amountSell" /></p>
				<input class ="sell" type="submit" name="submitSell" value="SELL"/> 
				</form>
				<br>
			</div>
		</div>
		<div id="messages" style="width:90%;padding: 0% 5% 0% 5%;">
			
			<?php if (!empty($error) || !empty($serverMessage)){
			  
			  echo "<div class=\"isa_info\" style=\"width:60%;\">";
			  echo "<i class=\"fa fa-info-circle\"></i>";
			  echo $error . "<br>";
			  echo $serverMessage;
			  echo "</div>";
			}
			?>
			
				
		</div>
		<div id="orders" style="width:90%;padding: 0% 5% 0% 5%;">
			<div id="openOrders" style="width:100%;float:left;">
				<h1>Open Orders</h1>
				<br>
				<?php  include 'getOpenOrders.php'; ?>
				<br>
			</div>
			<div id="allOrders" style="width:100%;">
				<h1>Order History<h1>
				<br>
				<?php include 'getAllOrders.php'; ?>
			</div>
		</div>
	</div>
	</body>
</html>