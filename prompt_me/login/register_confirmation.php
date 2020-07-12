<?php

require '../config/config.php';

// server side validation
if ( !isset($_POST['username']) || empty($_POST['username'])
	|| !isset($_POST['password']) || empty($_POST['password']) ) {
	$error = "Please fill out all required fields.";
}
else {
	// Connect to database and add this user into our DB
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME); 
	if($mysqli->connect_errno){
		echo $mysqli->connect_error;
		exit();
	}

	// Check if username or email already exists in the users table
	$sql_registered = "SELECT * FROM users 
	WHERE username = '" . $_POST["username"] . "';"; 

	$results_registered = $mysqli->query($sql_registered); 
	if(!$results_registered){
		echo $mysqli->error; 
		exit(); 
	}

	// var_dump($results_registered);
	if($results_registered->num_rows > 0){
		// If there is even 1 match in the user table
		$error = "Username has already been taken. Please choose another one."; 
	}
	else{
	// Hashing passwords
	$password = hash("sha256", $_POST["password"]);

	// Add this user into our DB
	$sql = "INSERT INTO users(username, password) VALUES('" . $_POST["username"] . "','" . $password . "');"; 

	$results = $mysqli->query($sql); 
	if(!$results){
		echo $mysqli->error;
		exit();
	}
}

	$mysqli->close();

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Registration Confirmation</title>
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
            <a class="nav-link active" href="login.php">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="register_form.php"><strong>Sign Up</strong></a>
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

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">User Registration</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger"><?php echo $error; ?></div>
				<?php else : ?>
					<div class="text-success"><?php echo $_POST['username']; ?> was successfully registered.</div>
				<?php endif; ?>
		</div> <!-- .col -->
	</div> <!-- .row -->

	<div class="row mt-4 mb-4">
		<div class="col-12">
			<a href="login.php" role="button" class="btn btn-primary">Login</a>
			<a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" role="button" class="btn btn-light">Back</a>
		</div> <!-- .col -->
	</div> <!-- .row -->

</div> <!-- .container -->

</body>
</html>