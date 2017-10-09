<html>
	<head>
		<title>Binance API Competition</title>
		<meta http-equiv="content-type" content="text/html;charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/font-awesome.min.css">
	</head>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#"><img src="resources/logo-en.svg" style="height:22px;"></a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="#">Home</a></li>
			  <li><a href="markets.php">Markets</a></li>
			  <li><a href="wallet.php">Wallet</a></li>
			  <li class="active"><a href="account.php">Account</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			<li><a href="markets/update.php">Update</a></li>
			</ul>
		  </div>
		</nav>
	<body>
	 <div class="container" style="width: 90%; height: 90%;">
		<h1> Account Setup </h1>
		<hr>
		
		<?php
		if( !empty($_POST["api"]) && !empty($_POST["secret"] )) {
			echo "<h2>Successfully created key pair file!</h2><br>"; 
			echo "API Key: ". $_POST['api']. "<br>";
			echo "Secret Key: ". $_POST['secret']. "<br><br>";
			echo "<a class = \"btn btn-primary\" href=\"account.php\">Go Back</a>";
			echo " <a class = \"btn btn-primary\" href=\"wallet.php\">Check Wallet</a>";
			$myfile = fopen("api.php", "w") or die("Unable to open file!");
			$txt = "<?php \n$" . "apiKey=\"" . $_POST['api'] . "\";\n" . "$" . "secretKey=\"" . $_POST['secret'] . "\";\n?>";
			fwrite($myfile, $txt);
			fclose($myfile);
			exit();
		} else if ( !empty($_POST["api"]) || !empty($_POST["secret"] )) {
			echo "<h2>Unsuccessful! Please fill in both API and Secret Keys!</h2><br>";
		}
   ?>
   <p> To enable your account fill out the form below </p>
		<form action="<?php $_PHP_SELF ?>" method="post">
			API Key : <input type="text" name="api" /><br>
			Secret Key : <input type="text" name="secret" /></p>
			<input class ="btn btn-primary" type="submit" name="submit" value="Add Account"/> 
		</form> 

	 </div>
	</body>


</html>