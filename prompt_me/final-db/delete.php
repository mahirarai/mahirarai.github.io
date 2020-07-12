<?php

require '../config/config.php'; 

$isDeleted = false;

if ( !isset($_GET['prompt_id']) || empty($_GET['prompt_id'])) {
	$error = "Invalid prompt.";
}
else {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	// Prepared statement way
	$statement = $mysqli->prepare("DELETE FROM prompts WHERE id = ?"); 
	$statement->bind_param("i", $_GET["prompt_id"]);
	$executed = $statement->execute(); 
	if(!$executed) {
		echo $mysqli->error; 
		exit(); 
	}

	// affected_rows returns how many records were deleted
	if($statement->affected_rows == 1){
		$isDeleted = true; 
	}

	$statement->close(); 
	$mysqli->close(); 

}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete Prompt</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="style.css">
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
            <a class="nav-link active" href="index.php">Main</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../login/login.php">Log In</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../login/register_form.php">Sign Up</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="about.php">About</a>
          </li>

          <?php else: ?>

            <li class="nav-item">
            <a class="nav-link active" href="index.php">Main</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="saved.php"><strong>Profile</strong></a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="../login/logout.php">Log Out</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" href="about.php">About</a>
          </li>

          <?php endif; ?>
          
        </ul>
      </div>
    </nav> 
    <!-- end nav -->

	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if ( $isDeleted ) :?>
					<div>Prompt was successfully deleted.</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="saved.php" role="button" class="btn btn-primary">Back to Profile</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>