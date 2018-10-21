<?php
session_start();
require_once 'php/google-api-php-client/vendor/autoload.php';
?>

<?php

	if (isset($_POST['search'])) {

		$query = "SELECT Street_address, Trading_name FROM [restaurants.restaurant_data] WHERE Street_address LIKE '%" . $_POST['location'] ."%' GROUP BY Street_address, Trading_name LIMIT 20";

		$client = new Google_Client();
		$client->useApplicationDefaultCredentials();
		$client->addScope(Google_Service_Bigquery::BIGQUERY);
		$bigquery = new Google_Service_Bigquery($client);
		$projectId = 's3622567-s3629975';

		$request = new Google_Service_Bigquery_QueryRequest();
		$str = '';

		$request->setQuery($query);

		$response=$bigquery->jobs->query($projectId, $request);
		$rows=$response->getRows();

		
		$str = "<table>".
		"<tr>" .
		"<th>Street_address</th>" .
		"<th>Trading_name</th>" .
		"</tr>";

		foreach ($rows as $row)
		{
			$str .= "<tr>";

			foreach ($row['f'] as $field)
			{
				$str .= "<td>" . $field['v'] . "</td>";
			}
			$str .= "</tr>";
		}

		$str .= '</table></div>';

		//echo $str;
	}
?>

<head>
  <link rel='stylesheet' type='text/css' href='/css/style.css'>
  <script src="/javascript/App.js"></script>
</head>

<div class="header" style="padding: 10px; background-color: Mistyrose; margin: 10px; border: double;"><h1>BORED BEAR</h1></div>
<div class="row">
  <div class="column">
  <h2>Big Query - Location find.</h2>
  <div style="float: left, margin = 15px">
	<form method="POST">
    	<h4>Input street name where you are now: </h4>
    	<input type="text" name="location" id="location">
    	<button type="submit" name="search" id="search">Search</button><br>
	</form>
	<div class="content">
	<?php
	echo $str;
	?>
	<br>
    </div>
   </div>
</div>
<div class="column">
    <h2>Dialogflow - Cloud Function Chatbot.</h2>
  <div style="">
		<iframe allow="microphone;" width="400" height="500" src="https://console.dialogflow.com/api-client/demo/embedded/2c136b02-4e7c-49a3-98e7-8abda949bb63">
		</iframe>
	</div>
      </div>
<div class="column">
    <h2>Google Maps API - Search Function</h2>
	<button  onclick="findPlacesAroundMe()">Find Restaurants Near me</button>
  <div style="width: 100%" "height:100%" id="map">
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyClbvCczzp_wOtbZU7aSXuUcGj9DoT3Wmw&libraries=places&callback=initAutoComplete" async defer>
</script>

      </div>
      </div>
</div>
</div>
</div>
</div>