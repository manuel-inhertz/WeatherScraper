<?php
	$weather = "";
	$error = "";
	$weatherArray ="";

	if ($_POST){
		$urlContents = file_get_contents('http://api.openweathermap.org/data/2.5/weather?q='.urlencode($_POST['city']).'&appid=023fc03f628142cd192f74ef29af3a88');
		$weatherArray = json_decode($urlContents, true);
		
		if ($weatherArray['cod'] == 200) {
			$weather = "The weather in ".$_POST['city']." is currently ".$weatherArray['weather'][0]['description'].".";

				$tempInCelcius = intval($weatherArray['main']['temp'] - 273);
			$weather .= " The temperature is ".$tempInCelcius."&deg;C and the wind speed is ".$weatherArray['wind']['speed']."m/s.";
		} else {
			$error = "Could not find city - please try again.";
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
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
			    overflow: hidden;
			}
		</style>
	</head>
	<body>
		<main>
			<div class="container text-center mt-3">
				<header>
					<h1>What's The Weather Like?</h1>
					<p class="lead">Enter the name of the city.</p>
				</header>
				<form id="autocomplete" method="post" class="form-group">
					<input class="form-control w-50 typeahead" type="text" id="city" name="city" placeholder="E.g: London" value="<?php echo $_POST['city']; ?>">
					<input class="btn btn-primary" type="submit" name="submit">
				</form>
				<div id="results" class="w-100">
					<?php 
						if ($_POST AND $weatherArray['cod'] == 200) {
							echo "<div class='alert alert-success w-75 m-0 m-auto'><p class='results'>".$weather."</p></div>";
						} else if ($_POST AND $weatherArray['cod'] != 200) {
							echo "<div class='alert alert-danger w-50 m-0 m-auto'><p class='error'>".$error."</p></div>";
						} else if (!$_POST) {
							echo "<span></span>";
						}
					?>
				</div>
			</div>
		</main>
		<footer>
				
		</footer>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>
		<script type="text/javascript">
			document.addEventListener('gesturestart', function (e) {
			    e.preventDefault();
			});
		</script>
	</body>
</html>