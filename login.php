<?php
	session_start();
	$submitted = !isset($_POST['login']);

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
			echo $submitted;
			header("Location: BoredBear.php");
			
			}
?>

<head>
  <link rel='stylesheet' type='text/css' href='/css/style.css'>
  <script src="/javascript/javascript.js"></script>
</head>
					
<div class="BoredBear">
  <div class="ear"></div>
  <div class="face">
    <div class="eye-shade"></div>
    <div class="eye-white">
      <div class="eye-ball"></div>
    </div>
    <div class="eye-shade rgt"></div>
    <div class="eye-white rgt">
      <div class="eye-ball"></div>
    </div>
    <div class="nose"></div>
    <div class="mouth"></div>
  </div>
  <div class="body"> </div>
  <div class="foot">
    <div class="finger"></div>
  </div>
  <div class="foot rgt">
    <div class="finger"></div>
  </div>
</div>
<form class="formlogin" method="POST" action="BoredBear.php">
  <div class="hand"></div>
  <div class="hand rgt"></div>
  <h1>BoredBear Login</h1>
  <div class="form-group">
    <input required="required" class="form-control type="text" name="username" id="username"/>
    <label class="form-label">Username    </label>
  </div>
  <div class="form-group">
    <input id="password" type="password" required="required" class="form-control"/>
    <label class="form-label">Password</label>
    <p class="alert">Invalid Credentials..!!</p>
	<button class="btn" type="submit" name="login" id="login">Login</button>
  </div>
</form>