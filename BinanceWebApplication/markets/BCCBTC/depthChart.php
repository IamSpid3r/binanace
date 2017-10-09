<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($ch, CURLOPT_URL,"https://www.binance.com/api/v1/depth?symbol=".$symbol); 
	$result = curl_exec($ch);		
	//Decode json
	$json = json_decode($result);
	curl_close($ch);
	$totalbids = (sizeof($json->bids)-1);
	$totalasks = (sizeof($json->bids)-1);

	$lowestbid = $json->bids[$totalbids][0];
	$highestask = $json->asks[$totalasks][0];
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
    <div id="chart_div" style="width: 50%; height: 500px;float:left"></div>
  </body>
</html