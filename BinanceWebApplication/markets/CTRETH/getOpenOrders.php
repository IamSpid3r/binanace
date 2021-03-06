<?php
	$serverTimestamp = time()*1000; // Take current UNIX timestamp and convert to miliseconds
	
	$ch = curl_init(); // Initialise cURL
	$params = "symbol=$symbol&timestamp=$serverTimestamp"; // Set required paramaters
	$signiture = hash_hmac("sha256", $params, $secretKey); // Take the parameters, and sign them with the Secret Key
	curl_setopt($ch, CURLOPT_URL, "https://www.binance.com/api/v3/openOrders?$params&signature=$signiture"); // Set URL + Parameters + Signiture
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Return values
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); // HTTP Method to GET

	$headers = array(); // Set up our Headers
	$headers[] = "X-Mbx-Apikey: $apiKey"; // Put the API Key in HTTP Header 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Enable Headers

	$result = curl_exec($ch); // Execute cURL command
	if (curl_errno($ch)) { // Check if any errors
		echo 'Error: ' . curl_error($ch); // Display Errors
	}
	$json = json_decode($result);
	curl_close ($ch);
	?>
	<table id="example" class="display" cellspacing="0" width="30%">
		<thead>
			<tr>
			<th>Buy/Sell</th>
			<th>Price</th>
			<th>Status</th>
			<th>Units</th>
			<th>Units Filled</th>
			<th>Order ID</th>
			<th>Action</th>
			</tr>
		</thead>
		<tr> 
		<tbody>
	<?php
	for ($i=0; $i<sizeof($json); $i++) {
		$id = $json[$i]->orderId;
		echo "<tr>";
		echo "<td>" . $json[$i]->side . "</td>";
		echo "<td>" . $json[$i]->price . "</td>";
		echo "<td>" . $json[$i]->status . "</td>";
		echo "<td>" . $json[$i]->origQty . "</td>";
		echo "<td>" . $json[$i]->executedQty . "</td>";
		echo "<td>" . $json[$i]->orderId . "</td>";
		echo "<td><form action=\"" . $_PHP_SELF . "\" method=\"post\"><button name=\"cancelOrder\"  class=\"btn btn-primary\"type=\"submit\" value=\"$id\">Cancel</button></form></td>";
		echo "</tr>";
	}

	?>
		</tr>
	
		</tbody>
	</table>
<script>
$(document).ready(function() {
    $('#example').DataTable();
} );
</script>