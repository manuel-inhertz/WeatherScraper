<?php
	function curl_get_contents($url)
	{
	  $curl = curl_init($url);
	  curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	  curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
	  curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
	  $data = curl_exec($curl);
	  curl_close($curl);
	  return $data;
	} 

	$finalResult[0] = "";
	$error = "";

	if ($_POST){
		$city = $_POST['city'];
		$cityArray = explode(" ", $city);
		$file_headers = @get_headers('https://www.weather-forecast.com/locations/'.implode("-",$cityArray).'/forecasts/latest');
		if($file_headers[0] == 'HTTP/1.1 404 Not Found') {
		    $error = "That city could not be found";
		} else {
		$url = 'https://www.weather-forecast.com/locations/'.implode("-",$cityArray).'/forecasts/latest';
		$content = curl_get_contents($url);
		$first_step = explode( '<span class="phrase">' , $content );
		$finalResult = explode("</span>" , $first_step[1] );
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Weather Scraper</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link href="css/style.css" rel="stylesheet" />
		<link rel="icon" href="favicon.ico" type="image/x-icon" />
		<style type="text/css">
			body {
			  margin: 0;
			  padding: 0;
			  background: url("img/weather-1.jpeg") no-repeat center center fixed;
			    -webkit-background-size: cover;
			    -moz-background-size: cover;
			    -o-background-size: cover;
			    background-size: cover;
			}
		</style>
	</head>
	<body>
		<main>
			<div class="container text-center mt-3">
				<header>
					<h1 class="display-4">What's The Weather Like?</h1>
					<p class="lead">Enter the name of the city.</p>
				</header>
				<form id="autocomplete" method="post" class="form-group">
					<input class="form-control w-50 typeahead" type="text" id="city" name="city" placeholder="E.g: London">
					<input class="btn btn-primary" type="submit" name="submit">
				</form>
				<div id="results" class="w-100">
					<?php 
						if ($finalResult[0]) {
							echo "<div class='alert alert-success'><p class='results'>".$finalResult[0]."</p></div>";
						} else if ($_POST) {
							echo "<div class='alert alert-danger'><p class='error'>That city could not be found</p></div>";
						} else {
							echo "<span></span>";
						}
					?>
				</div>
			</div>
		</main>
		<footer>
			<center><div class="m-0 m-auto">
				<p>Weather Info provided by : <a href="https://www.weather-forecast.com/">WeatherForecast.com</a></p>
			</div></center>
		</footer>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script src="http://twitter.github.io/typeahead.js/releases/latest/typeahead.bundle.js"></script>
	</body>
</html>