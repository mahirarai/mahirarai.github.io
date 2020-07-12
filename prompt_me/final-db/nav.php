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

