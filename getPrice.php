<?php

	$symbol = "BNBBTC"; // Set Symbol
	$ch = curl_init(); // Initialise cURL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // SSL Cert Verification False, we don't need to sign this
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	 // Return results
	curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/ticker/24hr?symbol=".$symbol); //Set URL
	$result = curl_exec($ch); // Exectute cURL command
	//Decode json
	$json = json_decode($result); // Results returned in jSON, decode and store in $json
		
	$price = $json->lastPrice; //Access the object lastPrice
	echo $price; 