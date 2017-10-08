<?php

	$symbol = "BNBBTC"; // Set Symbol
	$ch = curl_init(); // Initialise cURL
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // We don't need to sign this
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	 // Return results
	curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/depth?symbol=".$symbol); // Set URL
	$result = curl_exec($ch); // Execute cURL command
	
	$json = json_decode($result); //Decode returned jSON
	
	// Example build on depth graph//
	$totalbids = (sizeof($json->bids)-1); // See how many BIDS we have 
	$totalasks = (sizeof($json->bids)-1); // See how many ASKS we have

	$lowestbid = $json->bids[$totalbids][0]; // Define lowest BID 
	$highestask = $json->asks[$totalasks][0]; // Define highest ASK
	
	for ($i=0; $i<($totalasks+1); $i++) {
		
		$bids[] = array (
		'bidprice'=>$json->bids[$i][0],
		'amount'=>$json->bids[$i][1],
		'null'=>0
		);
		$asks[] = array (
		'askprice'=>$json->asks[$i][0],
		'amount'=>$json->asks[$i][1],
		'null'=>0
		); 
}

?>
  <html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['PRICE',  'BIDS', 'ASKS'],
          <?php 
		  $totalbids=0;
		  $totalasks=0;
		foreach($bids as $bid) {
		  echo "[" . $bid['bidprice'] . ", " . ($totalbids+=$bid['amount']) . ", " . "0],";
		}  
		  foreach($asks as $ask) {
		 echo "[" . $ask['askprice'] . ", " . "0, ". ($totalasks+=$ask['amount']) . "],";
		}
		?>
        ]);

        var options = {
          title: 'Order Book',
          vAxis: {title: ''},
		  hAxis: {title: '', viewWindow: { min:<?php echo $lowestbid;?>, max:<?php echo $highestask;?>}},
          isStacked: false,
		  colors: ['#00ff00', '#e0440e'],
		  legend: 'none'
        };

        var chart = new google.visualization.SteppedAreaChart(document.getElementById('chart_div'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="chart_div" style="width: 900px; height: 500px;"></div>
  </body>
</html>