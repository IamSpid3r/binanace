<html>

	<head>
		<title>Binance API Competition</title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="../css/font-awesome.min.css">
	</head>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#"><img src="../resources/logo-en.svg" style="height:22px;"></a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="../">Home</a></li>
			  <li><a href="../markets.php">Markets</a></li>
			  <li><a href="../wallet.php">Wallet</a></li>
			  <li><a href="../account.php">Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li class="active"><a href="update.php">Update</a></li>
			</ul>
		  </div>
		</nav>
	<body>
	 <div class="container" style="width: 90%; height: 90%;">
		<h1> Update Markets </h1>
		<?php
			echo "[-] Update loading<br>";	
			
			$newmarkets=0;
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
			//Get all available markets
			curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/ticker/allPrices");
			$result = curl_exec($ch);		
			//Decode json
			$json = json_decode($result);	
			
			echo "[-] Looking for new markets<br>";
			for ($i=0; $i<sizeof($json); $i++) {
			
			$symbol= $json[$i]->symbol;
			if (!is_dir($symbol)) {
				$newmarkets++;
				echo "[!] New market found: " . $symbol . "<br>";
				mkdir($symbol, 0777, true);
				echo "[+] Copying files to newly created folder /markets/$symbol<br>";
				copy('template/index.php', $symbol.'/index.php');
				copy('template/buyOrder.php', $symbol.'/buyOrder.php');
				copy('template/cancelOrder.php', $symbol.'/cancelOrder.php');
				copy('template/currentPosition.php', $symbol.'/currentPosition.php');
				copy('template/depthChart.php', $symbol.'/depthChart.php');
				copy('template/getAllOrders.php', $symbol.'/getAllOrders.php');
				copy('template/getCoinSymbol.php', $symbol.'/getCoinSymbol.php');
				copy('template/getOpenOrders.php', $symbol.'/getOpenOrders.php');
				copy('template/sellOrder.php', $symbol.'/sellOrder.php');
				}
			}
			
			if ($newmarkets==0) {
				echo "[-] No new markets found!";
			} else {
				echo "[!] Total of " . $newmarkets . " new market(s) found";
			}
		echo "<br><br><a class = \"btn btn-primary\" href=\"../markets.php\">Back to Markets</a>";
		?>
	 </div>
	</body>


</html>

