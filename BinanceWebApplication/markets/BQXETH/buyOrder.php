<?php	
		$side = "BUY";
		$timeinForce = "GTC";
		$quantity = $_POST["amountBuy"];
		$price = $_POST["priceBuy"];
		$serverTimestamp = time()*1000;;
		if (isset($_POST["marketOrder"])) {
			$type = "MARKET";
			$params="symbol=$symbol&side=$side&type=$type&quantity=$quantity&timestamp=$serverTimestamp";
		} else {
			$type = "LIMIT";
			$params="symbol=$symbol&side=$side&type=$type&timeInForce=$timeinForce&quantity=$quantity&price=$price&timestamp=$serverTimestamp";
		}
	$signiture = hash_hmac("sha256", $params, $secretKey);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/order?$params&signature=$signiture");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	$test = "https://www.binance.com/api/v3/order?$params&signature=$signiture";
	$headers = array();
	$headers[] = "X-Mbx-Apikey: $apiKey";
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$resultOrder = curl_exec($ch);
	if (curl_errno($ch)) {
		$error = 'Error:' . curl_error($ch);
	}
	curl_close($ch);
	$serverMessage = $resultOrder;
?>