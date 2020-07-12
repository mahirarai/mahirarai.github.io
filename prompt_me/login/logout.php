<?php

require '../config/config.php';
	session_destroy();

  header("Location: ../final-db/index.php");

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Logout</title>
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
            <a class="nav-link active" href="logout.php"><strong>Log Out</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../final-db/about.php">About</a>
          </li>

          <?php endif; ?>
          
        </ul>
      </div>
    </nav>

	<div class="container">
		<div class="row confirm">
			<div class="col-12">You are logged out.</div>

		</div> <!-- .row -->
	</div> <!-- .container -->

</body>
</html>