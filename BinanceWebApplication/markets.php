<?php
//Initalise Curl and Arrays
	$coins[]=array();
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	//Get all available markets
	curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/ticker/allPrices");
	$result = curl_exec($ch);		
	//Decode json
	$json = json_decode($result);	
	
	for ($i=0; $i<sizeof($json); $i++) {
	
	$coins[] = array( 'symbol'=>$json[$i]->symbol,
					  'last'=>$json[$i]->price
		  );
		  
	}

	$BTCmarkets=array();
	$ETHmarkets=array();
	$USDTmarkets=array();
	
	foreach($coins as $coin) {
		if (substr($coin['symbol'],-3) == "BTC") {
			
			$BTCmarkets[]=array(
							'symbol'=>$coin['symbol'],
							'ticker'=>(substr($coin['symbol'],0,-3)),
							'price'=>$coin['last']
							);
			
		} else if (substr($coin['symbol'],-3) == "ETH")  {
			$ETHmarkets[]=array(
							'symbol'=>$coin['symbol'],
							'ticker'=>(substr($coin['symbol'],0,-3)),
							'price'=>$coin['last']		
							);
		} else if (substr($coin['symbol'],-4) == "USDT") {
			$USDTmarkets[]=array(
							'symbol'=>$coin['symbol'],
							'ticker'=>(substr($coin['symbol'],0,-4)),
							'price'=>$coin['last']
							);	
		}
	}
?>
<html>

	<head>
		<title>Binance API Competition</title>
	
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/font-awesome.min.css">
				<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="css/jquery.dataTables.min.css">
	</head>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#"><img src="resources/logo-en.svg" style="height:22px;"></a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="#">Home</a></li>
			  <li class="active"><a href="markets.php">Markets</a></li>
			  <li><a href="wallet.php">Wallet</a></li>
			  <li><a href="account.php">Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="markets/update.php">Update</a></li>
			</ul>
		  </div>
		</nav>
	<body>
	 <div class="container" style="width: 90%; height: 90%;">
	 
		<h1><img src="resources/BTC.png"> BITCOIN MARKETS </h1>
		<hr>
			<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Coin</th>
			<th>Last</th>
			</tr>
			</thead>
			<?php foreach($BTCmarkets as $BTCmarket) { 
			echo "<tr><td><a href=\"markets/". $BTCmarket['symbol']. "\">".$BTCmarket['ticker']."/BTC</a></td>"; 
			echo "<td>".$BTCmarket['price']."</td>";
			echo "</tr>";
			}?>
			</table>
		<h1><img src="resources/ETH.png"> ETHEREUM MARKETS </h1>
		<hr>
			<table id="example2" class="display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Coin</th>
			<th>Last</th>
			</tr>
			</thead>
			<?php foreach($ETHmarkets as $ETHmarket) { 
			echo "<tr><td><a href=\"markets/". $ETHmarket['symbol']. "\">".$ETHmarket['ticker']."/ETH</a></td>"; 
			echo "<td>".$ETHmarket['price']."</td>";
			echo "</tr>";
			}?>
			</table>
		<h1> <img src="resources/USDT.png"> USDT MARKETS </h1>
		<hr>
			<table id="example3" class="display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Coin</th>
			<th>Last</th>
			</tr>
			</thead>
			<?php foreach($USDTmarkets as $USDTmarket) { 
			echo "<tr>";
			echo "<td><a href=\"markets/". $USDTmarket['symbol']. "\">".$USDTmarket['ticker']."/USDT</a></td>"; 
			echo "<td>".$USDTmarket['price']."</td>";
			echo "</tr>";
			}?>
			</table>		
	 </div>
	</body>


</html>


<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
$(document).ready(function() {
    $('#example2').DataTable();
} );
$(document).ready(function() {
    $('#example3').DataTable();
} );
</script>