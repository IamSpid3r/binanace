<?php
	//Set Keys
	$apiKey = "J8MCTyOkmgXp0bxpSRcn8EZOvTXS3IUe6Tn0ehq297MePh6NR8DPGFGGFJ8uwDTB"; // Set your API Key
	$secretKey = "Ylgev0rMHk41SCQHX21gd4GlZBn9hD7rQDOElQfGldnIDlp1bYz5EKfYgEam8ZML"; // Set your Secret Key
	
	//BUY or SELL Information
	$symbol = "BNBBTC"; // Set which pair you want to BUY or SELL
	$side = "BUY"; // "BUY" or "SELL"
	$timeinForce = "GTC"; // "GTC"(Good till Cancelled) or "IOC"(Immediate or Cancel)
	$quantity = 1; // How many you want to buy
	$price = 0.0034; // How much to pay
	$serverTimestamp = time()*1000; // Take current UNIX timestamp and convert to miliseconds
	$type = "MARKET"; // "LIMIT" or "MARKET" (Best Market Price)
	//For Market Order
	$params="symbol=$symbol&side=$side&type=$type&quantity=$quantity&timestamp=$serverTimestamp";
	//For Limit Order
	//$params="symbol=$symbol&side=$side&type=$type&timeInForce=$timeinForce&quantity=$quantity&price=$price&timestamp=$serverTimestamp";
	$signiture = hash_hmac("sha256", $params, $secretKey); // Take the parameters, and sign them with the Secret Key
	
	$ch = curl_init(); // Initiate cURL
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/order?$params&signature=$signiture"); // Set URL + Parameters + Signiture
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Recieve response from API Request
	curl_setopt($ch, CURLOPT_POST, 1); // Set HTTP method to POST
	$headers = array(); // Set up our Headers
	$headers[] = "X-Mbx-Apikey: $apiKey"; // Put the API Key in HTTP Header 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Enable Headers

	$result = curl_exec($ch); // Execute cURL command
	if (curl_errno($ch)) { // Check for errors
		echo 'Error:' . curl_error($ch); // Display error
	}
	print_r($result); // Print results
	
?>