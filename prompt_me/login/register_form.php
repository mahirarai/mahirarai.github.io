
<?php

require '../config/config.php';

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Register</title>
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

	<div class="container confirm">

		<form action="register_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="username-id" class="col-sm-3 col-form-label text-sm-right">Username: <span class="text-danger">*</span></label>
				<div class="col-sm-4">
					<input type="text" class="form-control" id="username-id" name="username">
					<small id="username-error" class="invalid-feedback">Username is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="password-id" class="col-sm-3 col-form-label text-sm-right">Password: <span class="text-danger">*</span></label>
				<div class="col-sm-4">
					<input type="password" class="form-control" id="password-id" name="password">
					<small id="password-error" class="invalid-feedback">Password is required.</small>
				</div>
			</div> <!-- .form-group -->

			<div class="row">
				<div class="ml-auto col-sm-9">
					<span class="text-danger font-italic">* Required</span>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm- mt-3">
					<button type="submit" class="btn btn-primary">Register</button>
					<a href="login.php" role="button" class="btn btn-light">Cancel</a>
				</div>
			</div> <!-- .form-group -->

		</form>
	</div> <!-- .container -->
	<script>
		// client-side validation
		document.querySelector('form').onsubmit = function(){
			if ( document.querySelector('#username-id').value.trim().length == 0 ) {
				document.querySelector('#username-id').classList.add('is-invalid');
			} else {
				document.querySelector('#username-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#email-id').value.trim().length == 0 ) {
				document.querySelector('#email-id').classList.add('is-invalid');
			} else {
				document.querySelector('#email-id').classList.remove('is-invalid');
			}

			if ( document.querySelector('#password-id').value.trim().length == 0 ) {
				document.querySelector('#password-id').classList.add('is-invalid');
			} else {
				document.querySelector('#password-id').classList.remove('is-invalid');
			}

			return ( !document.querySelectorAll('.is-invalid').length > 0 );
		}
	</script>
</body>
</html>