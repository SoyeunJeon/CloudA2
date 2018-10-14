<html>
	<body>

		<?php
			$submitted = !isset($_POST['login']);

			echo $submitted;

			$user = $pwd = "";
			$check = $_POST['username'] . "," . $_POST['password'];

			$storage = explode("/", file_get_contents('gs://username-storage/users.txt'));
			$numUsers = count($storage);

			for ($i=0; $i < $numUsers; $i++) { 
				if ($check == $storage[$i]) {
					$user = $_POST['username'];
					$pwd = $_POST['password'];
				}
			}
			

			if (!$submitted && $user != "" && $pwd != "") {		
		?>

			<div class="header" style="padding: 20px; background-color: Mistyrose;">BORED BEAR</div>
				<div class="row">
					<div style="width: 40%">
						<iframe
							allow="microphone;"
							width="350"
							height="430"
							src="https://console.dialogflow.com/api-client/demo/embedded/2c136b02-4e7c-49a3-98e7-8abda949bb63">
						</iframe>
					</div>

					<div style="width: 60%">
						<form method="POST">
							Input street name where you are now: <input type="text" name="location" id="location">
							<input type="submit" name="search" id="search">Search</button><br/>
						</form>
						<?php

							if (isset($_POST['search'])) {

								$query = "SELECT Street_address, Trading_name FROM [test-project-210801:restaurant.restaurants_mel] WHERE REGEX_MATCH(Street_address, r'^" . $_POST['location'] . "')";
								echo $query;

								$client=new Google_Client();
								$client->useApplicationDefaultCredentials();
								$client->addScope(Google_Service_Bigquery==BIGQUERY);
								$bigquery=new Google_Service_Bigquery($client);
								$projectId='s3622567-s3629975';

								$request=new Google_Service_Bigquery_QueryRequest();
								$str='';

								$request->setQuery($query);

								$response=$bigquery->jobs->query($projectId, $request);
								$rows=$response->getRows();

								$str = "<table>".
								"<tr>" .
								"<th>Street_address</th>" .
								"<th>Trading_name</th>" .	
								"</tr>";

								foreach ($rows as $row) {
									$str .= "<tr>";

									foreach ($row['f'] as $field) {
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



		<?php
			} else {
		?>

		<div style="border-style: dotted; border-width: 1px; border-radius: 3px; margin: auto; margin-top: 100px; width: 300px; padding-left: 20px">
			<h1 color="blue" style="center">Login to Bored Bear</h1>
			<form method="POST">
				username: <input type="text" name="username" id="username"><br/><br/>
				password: <input type="password" name="password" id="password"><br/><br/>
				<button type="submit" name="login" id="login">Login</button>
			</form>
		</div>

		<?php
			}
		?>

	</body>
</html>

