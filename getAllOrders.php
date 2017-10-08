<?php
	//SET KEYS
	$apiKey = "vmPUZE6mv9SD5VNHk4HlWFsOr6aKE2zvsw0MuIgwCIPy6utIco14y7Ju91duEh8A"; // Set your API Key
	$secretKey = "NhqPtmdSJYdKjVHjA7PZj4Mge3R5YNiP1e3UZjInClVN65XAbvqqM6A7H5fATj0j"; // Set your Secret Key
	
	$symbol = "BNBBTC"; // Set which pair you want to get orders for
	$serverTimestamp = time()*1000; // Take current UNIX timestamp and convert to miliseconds
	
	$ch = curl_init(); // Initialise cURL
	$params = "symbol=$symbol&timestamp=$serverTimestamp"; // Set required paramaters
	$signiture = hash_hmac("sha256", $params, $secretKey); // Take the parameters, and sign them with the Secret Key
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/allOrders?$params&signature=$signiture"); // Set URL + Parameters + Signiture
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return values
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // HTTP Method to GET

	$headers = array(); // Set up our Headers
	$headers[] = "X-Mbx-Apikey: $apiKey"; // Put the API Key in HTTP Header 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Enable Headers

	$result = curl_exec($ch); // Execute cURL command
	if (curl_errno($ch)) { // Check if any errors
		echo 'Error: ' . curl_error($ch); // Display Errors
	}
	curl_close ($ch); // Close cURL
	print_r($result); // Print Results
	

	?>
