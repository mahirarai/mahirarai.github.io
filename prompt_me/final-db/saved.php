<?php

  require '../config/config.php';

  // if user not logged in, redirect to login page 
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

  // if deleting
  if (isset($_GET['prompt_id']) || !empty($_GET['prompt_id'])) {
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
      // echo "worked";
    }
    else{
      // echo "didnt work";
    }
  }

  $sql_saved = "SELECT prompts.id AS prompt_id, user_id, format, topic, feeling FROM prompts 
  JOIN formats ON prompts.format_id = formats.id
  JOIN topics ON prompts.topic_id = topics.id
  JOIN feelings ON prompts.feeling_id = feelings.id 
  WHERE user_id =" . $user_id . ";";
  $results_saved = $mysqli->query($sql_saved);
  if ( !$results_saved ) {
    echo $mysqli->error;
    exit();
  }

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

  // // updating password
  // if (isset($_POST["update-name"]) && !empty($_POST["update-name"])) {
  //   $nameUpdate = $_POST["update-name"];
  //   $sql_update = "UPDATE users SET username = '" . $nameUpdate . "; WHERE id = " . $user_id . ";";
  //   $results_update = $mysqli->query($sql_update);
  //   if(!$results_update) {
  //     echo $mysqli->error;
  //     header("Location: saved.php");
  //   }
  //   else{
  //   }
  // }
     
  $mysqli->close();

  }
  
  
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, inital-scale=1">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="style.css">
  	<title>Creative Prompt</title>
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

    <div class="saved-main">

      <div id="profile-hello" class="p-2">
      <h2>Hi, <span id="text-name"><?php echo $_SESSION["user"];?></span>!</h2>

      </div>
      
      

      <div class="col-12" id="your-saved">
        <div><h4  class="add-dark">Your Saved Prompts</h4></div>
        <table class="table table-hover table-sm mt-6">
          <thead>
            <tr>
              <th class="add-dark">Format</th>
              <th class="add-dark">Topic</th>
              <th class="add-dark">Feeling</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php while ( $row = $results_saved->fetch_assoc() ) : ?>
              <tr>
                <td><?php echo $row['format']; ?></td>
                  <td><?php echo $row['topic']; ?></td>
                  <td><?php echo $row['feeling']; ?></td>
                  <td>
                    <a href="saved.php?prompt_id=<?php echo $row['prompt_id']; ?>" class="btn btn-outline-dark delete-btn btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div> <!-- .col -->

          <div id="nameupdate" >
            <form action="saved.php" method="POST" id="update-form">
              <div class="form-group row">
                <div class="col-4">
                  <input type="text" class="form-control" id="update-name" name="update-name">
                </div>
                <div >
                  <button type="submit" class="btn btn-outline-light btn-md" onclick="return confirm('Confirm, please.');">Update Name</button>
                </div>
              </div> <!-- .form-group -->
            </form>
          </div>

      </div> <!-- .col -->

      <script>

        document.querySelector("#update-name").oninput = function(){
          let textInput = document.querySelector("#update-name").value; 
          document.querySelector("#text-name").innerHTML = textInput;
        }
        
      </script>

</body>
</html>
