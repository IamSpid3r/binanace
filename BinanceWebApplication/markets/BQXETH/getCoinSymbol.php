<?php

	function getCurrentDirectory() {
	$path = dirname($_SERVER['PHP_SELF']);
	$position = strrpos($path,'/') + 1;
	return substr($path,$position);
	}
	
	$symbol = getCurrentDirectory();
	
		if (substr($symbol,-3) == "BTC") {
			$coin = substr($symbol,0,-3);
			$pair = "BTC";
		} else if (substr($symbol,-3) == "ETH") {
			$coin = substr($symbol,0,-3);
			$pair = "ETH";
		} else if (substr($symbol,-3) == "USDT") {
			$coin = substr($symbol,0,-4);
			$pair = "USDT";
		}
?>