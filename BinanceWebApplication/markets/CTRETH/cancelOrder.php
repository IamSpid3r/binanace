<?php
	
	$serverTimestamp = time()*1000; // Take current UNIX timestamp and convert to miliseconds
		
	$params = "symbol=$symbol&orderId=$orderID&timestamp=$serverTimestamp";  // Set required paramaters
	$signiture = hash_hmac("sha256", $params, $secretKey); // Take the parameters, and sign them with the Secret Key

	$ch = curl_init(); // Initialise cURL
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/order?$params&signature=$signiture"); // Set URL + Parameters + Signiture
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return values
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE"); // Set HTTP Method to "DELETE"

	$headers = array(); // Set up our Headers
	$headers[] = "X-Mbx-Apikey: $apiKey"; // Put the API Key in HTTP Header 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Enable Headers

	$resultOrder = curl_exec($ch); // Execute cURL command
	if (curl_errno($ch)) { // Check if any errors
		$error = 'Error: ' . curl_error($ch); // Display Errors
	}
	curl_close($ch);
	$serverMessage = $resultOrder;

?>