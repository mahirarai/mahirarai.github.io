<?php

require '../config/config.php';

if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]){

	if ( isset($_POST['username']) && isset($_POST['password']) ) {
		// If username OR password was not filled out
		if ( empty($_POST['username']) || empty($_POST['password']) ) {
			$error = "Please enter username and password.";
		}
		
		else {
			$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
			if($mysqli->connect_errno) {
				echo $mysqli->connect_error;
				exit();
			}
			$passwordInput = hash("sha256", $_POST["password"]);

			// Search the users table, look for the username $ pw combo that the user entered 
			$sql = "SELECT * FROM users
						WHERE username = '" . $_POST['username'] . "' AND password = '" . $passwordInput . "';";
			
			$results = $mysqli->query($sql);

			if(!$results) {
				echo $mysqli->error;
				exit();
			}

			// If there is a match, we will get one record back 
			if($results->num_rows > 0) {
				$_SESSION["user"] = $_POST["username"];
				$_SESSION["logged_in"] = true;
				
				// Redirect the logged in user to the home page
				header("Location: ../final-db/index.php"); 
			
			}
			else {
				$error = "Invalid username or password.";
			}
		} 
	}
}
	else{
		// Logged in user will go redirected
		header("Location: ../final-db/index.php");
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="../final-db/style.css">
</head>
<body>

	<nav class="navbar navbar-expand-lg navbar-light navbar-newcolor">
      <a class="navbar-brand" href="">Prompt Me</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav ml-auto">

          <?php if(!isset($_SESSION["logged_in"]) || !$_SESSION["logged_in"]) :?>

          <li class="nav-item">
            <a class="nav-link active" href="../final-db/index.php">Main</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="login.php"><strong>Log In</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="register_form.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../final-db/about.php">About</a>
          </li>

          <?php else: ?>

            <li class="nav-item">
            <a class="nav-link active" href="../final-db/index.php">Main</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../final-db/saved.php">Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="logout.php">Log Out</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../final-db/about.php">About</a>
          </li>

          <?php endif; ?>
          
        </ul>
      </div>
    </nav>


	<div class="container confirm">
		<form action="login.php" method="POST">

			<div class="row mb-3">
				<div class="font-italic text-danger col-sm-9 ml-sm-auto">
					<!-- Show errors here. -->
					<?php
						if ( isset($error) && !empty($error) ) {
							echo $error;
						}
					?>
				</div>
			</div> <!-- .row -->
			

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username:</label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="username-id" name="username">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password:</label>
				<div class="col-sm-4">
					<input type="password" class="form-control" id="password-id" name="password">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-4 mt-2">
					<button type="submit" class="btn btn-primary">Login</button>
				</div>
			</div> <!-- .form-group -->
		</form>

		<div class="row">
			<div class="col-sm-9 ml-sm-auto">
				<a href="register_form.php">Create an account</a>
			</div>
		</div> <!-- .row -->

	</div> <!-- .container -->
</body>
</html>