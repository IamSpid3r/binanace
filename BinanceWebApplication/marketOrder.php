<?php
	//SET KEYS
	$apiKey = "J8MCTyOkmgXp0bxpSRcn8EZOvTXS3IUe6Tn0ehq297MePh6NR8DPGFGGFJ8uwDTB"; // Set your API Key
	$secretKey = "Ylgev0rMHk41SCQHX21gd4GlZBn9hD7rQDOElQfGldnIDlp1bYz5EKfYgEam8ZML"; // Set your Secret Key
	
	$ch = curl_init(); // Initiate cURL
	$symbol = "BNBBTC"; // Set which pair you want to BUY or SELL
	$side = "BUY"; // "BUY" or "SELL"
	$type = "MARKET"; // "LIMIT" or "MARKET" (Best Market Price)
	$quantity = 1; // How many you want to buy
	$serverTimestamp = time()*1000; // Take current UNIX timestamp and convert to miliseconds


	$params="symbol=$symbol&side=$side&type=$type&quantity=$quantity&timestamp=$serverTimestamp"; // Set required paramaters

	$signiture = hash_hmac("sha256", $params, $secretKey); // Take the parameters, and sign them with the Secret Key
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/order?$params&signature=$signiture"); // Set URL + Parameters + Signiture
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Recieve response from API Request
	curl_setopt($ch, CURLOPT_POST, 1); // Set HTTP method to POST
	$test = "https://www.binance.com/api/v3/order?$params&signature=$signiture";
	$headers = array(); // Set up our Headers
	$headers[] = "X-Mbx-Apikey: $apiKey"; // Put the API Key in HTTP Header 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Enable Headers

	$result = curl_exec($ch); // Execute cURL command
	if (curl_errno($ch)) { // Check for errors
		echo 'Error:' . curl_error($ch); // Display error
	}
	curl_close ($ch); // Close cURL
	print_r($result); // Print results
	
?>