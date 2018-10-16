<?php
session_start();
require_once 'php/google-api-php-client/vendor/autoload.php';
?>

<div class="header" style="padding: 20px; background-color: Mistyrose;">BORED BEAR</div>
<div class="row" style="float: left">
	<div style="float: left">
		<iframe
			allow="microphone;"
			width="350"
			height="430"
			src="https://console.dialogflow.com/api-client/demo/embedded/2c136b02-4e7c-49a3-98e7-8abda949bb63">
		</iframe>
	</div>

	<div style="float: left, margin = 15px">
		<form method="POST">
			Input street name where you are now: <input type="text" name="location" id="location">
			<button type="submit" name="search" id="search">Search</button><br/>
		</form>
<div class="content">
<?php

	if (isset($_POST['search'])) {

		$query = "SELECT Street_address, Trading_name FROM [restaurants.restaurant_data] WHERE Street_address LIKE '%" . $_POST['location'] ."%' GROUP BY Street_address, Trading_name";

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

		echo $str;
	}
?>
</div>
	</div>
</div>