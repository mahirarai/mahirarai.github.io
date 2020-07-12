<?php

require '../config/config.php';

// DB Connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
  echo $mysqli->connect_error;
  exit();
}

$mysqli->set_charset('utf8');

// send queries and store results in array 
// FORMAT:
$sql_formats = "SELECT * FROM formats;";
$results_formats = $mysqli->query($sql_formats);
if ( $results_formats == false ) {
  echo $mysqli->error;
  exit();
}

$formats_array = array(); 
while ($row = $results_formats->fetch_assoc()){
  $formats_array[] = $row;
}

// TOPIC:
$sql_topics = "SELECT * FROM topics;";
$results_topics = $mysqli->query($sql_topics);
if ( $results_topics == false ) {
  echo $mysqli->error;
  exit();
}

$topics_array = array(); 
while ($row = $results_topics->fetch_assoc()){
  $topics_array[] = $row;
}

// FEELING
$sql_feelings = "SELECT * FROM feelings;";
$results_feelings = $mysqli->query($sql_feelings);
if ( $results_feelings == false ) {
  echo $mysqli->error;
  exit();
}

$feelings_array = array(); 
while ($row = $results_feelings->fetch_assoc()){
  $feelings_array[] = $row;
}

$format_prompt = false;
$topic_prompt = false;
$feeling_prompt = false;

// Close DB Connection
$mysqli->close();

if(isset($_POST['format-index'])){
  $format_ind = $_POST['format-index'];
  $format_prompt = true;
}
if(isset($_POST['topic-index'])){
  $topic_ind = $_POST['topic-index'];
  $topic_prompt = true;
}
if(isset($_POST['feeling-index'])){
  $feeling_ind = $_POST['feeling-index'];
  $feeling_prompt = true;
}


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
            <a class="nav-link active" href="index.php"><strong>Main</strong></a>
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
            <a class="nav-link active" href="index.php"><strong>Main</strong></a>
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

    <div id="main" >

      <div id="prompt" class="align-middle words add-dark">
        Create a 
          <span class="prompt-fill"> <?php if($format_prompt){echo $formats_array[$format_ind]["format"];}else{echo " _____ ";} ?> </span> 
          
          about 
          <span class="prompt-fill"> <?php if($topic_prompt){echo $topics_array[$topic_ind]["topic"];}else{echo " _____ ";} ?></span> 
          
          that evokes 
          <span class="prompt-fill"><?php if($feeling_prompt){echo $feelings_array[$feeling_ind]["feeling"];}else{echo " _____ ";} ?>.</span>
      </div>

      <div id="title" class="words">
        Click to fill your prompt:
      </div>

      <div class="container prompt-btns">
    
          <div class="row">
            <form action="index.php" method="POST" class="col-4">
              <input type="hidden" name="format-index" class="format-index format" value="">
              <input type="hidden" name="topic-index" class="topic-index format" value="">
              <input type="hidden" name="feeling-index" class="feeling-index format" value="">
              <button type="submit" id="btn-format" class="btn btn-dark btn-lg btn-block prompt-btn">format</button>
            </form>

            <form action="index.php" method="POST" class="col-4">
              <input type="hidden" name="format-index" class="format-index topic" value="">
              <input type="hidden" name="topic-index" class="topic-index topic" value="">
              <input type="hidden" name="feeling-index" class="feeling-index topic" value="">
              <button type="submit" id="btn-topic" class="btn btn-dark btn-lg btn-block prompt-btn">topic</button>
            </form>

            <form action="index.php" method="POST" class="col-4">
              <input type="hidden" name="format-index" class="format-index feeling" value="">
              <input type="hidden" name="topic-index" class="topic-index feeling" value="">
              <input type="hidden" name="feeling-index" class="feeling-index feeling" value="">
              <button type="submit" id="btn-feeling" class="btn btn-dark btn-lg btn-block prompt-btn">feeling</button>
            </form>
        </div> <!-- .row -->
      </div> <!-- .container -->

      <form action="save_confirmation.php" method="POST">
        <!-- send full prompt here -->
        <input type="hidden" name="format-index" class="format-index save" value="">
        <input type="hidden" name="topic-index" class="topic-index save" value="">
        <input type="hidden" name="feeling-index" class="feeling-index save" value="">

        <div class="form-group row">
          <div class="col-12 align-middle">
            <button type="submit" id="btn-save" class="btn btn-light btn-md">Save</button>
          </div>
        </div> <!-- .form-group -->
      </form>


    </div>


    <script
    src="https://code.jquery.com/jquery-3.4.1.min.js"
    integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
    crossorigin="anonymous"></script>

    <script>

      function setStyles() {
      // 1. Grab the saved key/values pairs from local storage
      let savedFormat = localStorage.getItem("format-index");
      let savedTopic = localStorage.getItem("topic-index");
       let savedFeeling = localStorage.getItem("feeling-index");

      // 2. Apply CSS with the saved values
      document.querySelector(".format-index.format").value = savedFormat;
      document.querySelector(".format-index.topic").value = savedFormat;
      document.querySelector(".format-index.feeling").value = savedFormat;
      document.querySelector(".format-index.save").value = savedFormat;
      console.log("format-index is: " + document.querySelector(".format-index.feeling").value);

      document.querySelector(".topic-index.format").value = savedTopic;
      document.querySelector(".topic-index.topic").value = savedTopic;
      document.querySelector(".topic-index.feeling").value = savedTopic;
      document.querySelector(".topic-index.save").value = savedTopic;
      console.log("topic-index is: " + document.querySelector(".topic-index.feeling").value);

      document.querySelector(".feeling-index.format").value = savedFeeling;
      document.querySelector(".feeling-index.topic").value = savedFeeling;
      document.querySelector(".feeling-index.feeling").value = savedFeeling;
      document.querySelector(".feeling-index.save").value = savedFeeling;
      console.log("feeling-index is: " + document.querySelector(".feeling-index.feeling").value);


    }

    function setDefault(){
      console.log("in set default");
      // 1. Grab the saved key/values pairs from local storage
      let savedFormat = " _____ ";
      let savedTopic = " _____ ";
       let savedFeeling = " _____ ";

      // 2. Apply CSS with the saved values
      document.querySelector(".format-index.format").value = savedFormat;
      document.querySelector(".format-index.topic").value = savedFormat;
      document.querySelector(".format-index.feeling").value = savedFormat;
      document.querySelector(".format-index.save").value = savedFormat;
      console.log("format-index is: " + document.querySelector(".format-index.feeling").value);

      document.querySelector(".topic-index.format").value = savedTopic;
      document.querySelector(".topic-index.topic").value = savedTopic;
      document.querySelector(".topic-index.feeling").value = savedTopic;
      document.querySelector(".topic-index.save").value = savedTopic;
      console.log("topic-index is: " + document.querySelector(".topic-index.feeling").value);

      document.querySelector(".feeling-index.format").value = savedFeeling;
      document.querySelector(".feeling-index.topic").value = savedFeeling;
      document.querySelector(".feeling-index.feeling").value = savedFeeling;
      document.querySelector(".feeling-index.save").value = savedFeeling;
      console.log("feeling-index is: " + document.querySelector(".feeling-index.feeling").value);
    }

    if(localStorage.getItem("format-index") || localStorage.getItem("topic-index") || localStorage.getItem("feeling-index")) {
      setStyles();
    }
    else{
      setDefault();
    }

    document.querySelector("#btn-format").onclick = function(event){
      // get random value and save that
      let formatIndex = Math.floor(Math.random() * 15);
      localStorage.setItem("format-index", formatIndex);
      setStyles();
    }

    document.querySelector("#btn-topic").onclick = function(event){
      // get random value and save that
      let topicIndex = Math.floor(Math.random() * 15);
      localStorage.setItem("topic-index", topicIndex);
      setStyles();
    }

    document.querySelector("#btn-feeling").onclick = function(event){
      // get random value and save that
      let feelingIndex = Math.floor(Math.random() * 15);
      localStorage.setItem("feeling-index", feelingIndex);
      setStyles();
    }



    </script>


</body>
</html>
