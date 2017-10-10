<?php
	include 'api.php'; // Get the API and Secret Keys to use in this page
	
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
			  <li><a href="markets.php">Markets</a></li>
			  <li class="active"><a href="wallet.php">Wallet</a></li>
			  <li><a href="account.php">Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="markets/update.php">Update</a></li>
			</ul>
		  </div>
		</nav>
	<body>
	 <div class="container" style="width: 90%; height: 90%;">
		<h1> Wallet(s) </h1>
		<hr>
		<?php 
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			$timestamp = time()*1000;
			$params = "timestamp=$timestamp";
			$signiture = hash_hmac("sha256", $params, $secretKey);
			curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/account?$params&signature=$signiture");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");


			$headers = array();
			$headers[] = "X-Mbx-Apikey: $apiKey";
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error: ' . curl_error($ch);
			}
			$json = json_decode($result);
			$balances=array();
			for ($i=0; $i<52; $i++) {
				$coin = $json->balances[$i]->asset;
				$available = $json->balances[$i]->free;
				$inOrder = $json->balances[$i]->locked;
				if (($available+$inOrder) != 0) { 
				$balances[]=array (
					'coin'=>$coin,
					'total'=>($available+$inOrder),
					'available'=>$available,
					'inTrade'=>$inOrder,
				);
				}
				
			}
			curl_close ($ch);
			?>
			<table id="example" class="display" cellspacing="0" width="100%">
			<thead>
			<tr>
			<th>Coin</th>
			<th>Total Balance</th>
			<th>Available</th>
			<th>In Order</th>
			</tr>
			</thead>
			<?php foreach($balances as $balance) { 
			echo "<tr><td><img src=\"resources/" .$balance['coin'] . ".png\"> ".$balance['coin']."</td>"; 
			echo "<td>".$balance['total']."</td>";
			echo "<td>".$balance['available']."</td>";
			echo "<td>".$balance['inTrade']."</td>";
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
</script>
