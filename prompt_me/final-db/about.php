<?php

require '../config/config.php';

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
  	<title>Prompt Me</title>
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
            <a class="nav-link active" href="about.php"><strong>About</strong></a>
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
            <a class="nav-link active" href="about.php"><strong>About</strong></a>
          </li>

          <?php endif; ?>
          
        </ul>
      </div>
    </nav>

    <div id="main" class="align-middle">

     <div id="about" class="align-middle words">
        <h2>About Prompt Me</h2>
        <br>
        <p>Prompt Me is an application that generates a project prompt to get you through a creative block. Click through each button in the main page, create an account to save your prompts, and most importantly, have fun! </p>
      </div>

    </div>


</body>
</html>
