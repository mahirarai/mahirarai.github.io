<?php
  require '../config/config.php';

  if(!isset($_SESSION["user"]) || !$_SESSION["logged_in"]){
    header("Location: ../login/login.php");
  }
  else{
  // DB Connection
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->errno ) {
      echo $mysqli->error;
      exit();
    }

    // get user
    $sql_user = "SELECT id AS user_id, username, password FROM users WHERE username LIKE '" . $_SESSION["user"] . "';";
    $results_user = $mysqli->query($sql_user);
    if ( !$results_user ) {
      echo $mysqli->error;
      exit();
    }

    $user_info = $results_user->fetch_assoc(); 
    $user_id = $user_info['user_id']; 

    // add prompt to database
    if ( isset($_POST['format-index']) && !empty($_POST['format-index'])) {
      $format_id = $_POST['format-index'] + 1; 
    } else {
      $format_id = 0; 
    } 
    if ( isset($_POST['topic-index']) && !empty($_POST['topic-index'])) {
      $topic_id = $_POST['topic-index'] + 1; 
    } else {
      $topic_id = 0; 
    } 
    if ( isset($_POST['feeling-index']) && !empty($_POST['feeling-index'])) {
      $feeling_id = $_POST['feeling-index'] + 1; 
    } else {
      $feeling_id = 0; 
    }

    echo $format_id . ", " . $topic_id . ", " . $feeling_id; 

    // insert prompt into database 
    $sql_prompt = "INSERT INTO prompts(format_id, topic_id, feeling_id, user_id) VALUES (" . $format_id . ", " . $topic_id . ", " . $feeling_id . ", " . $user_id . ");"; 
    $results_prompt = $mysqli->query($sql_prompt);
    if ( !$results_prompt ) {
      echo $mysqli->error;
      exit();
    }
    else{
      header("Location: index.php");
    }

    $mysqli->close();
  }
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Save Confirmation</title>
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
            <a class="nav-link active" href="saved.php">Profile</a>
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
	
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12"> 

	<?php if ( isset($error) && !empty($error) ) : ?>

		<div class="text-danger">
			<?php echo "Can't save"; ?>
		</div>

	<?php else : ?>

		<div class="text-success">
			<span class="font-italic">Prompt was successfully added.
		</div>

	<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="index.php" role="button" class="btn btn-primary">Back</a>
        <a href="saved.php" role="button" class="btn btn-light">Profile</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>