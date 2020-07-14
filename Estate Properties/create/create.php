<?php 


// Include config file
// require_once "login/config.php";


// Connect to Database 
require_once '../dbConfig.php';


// Message Output
if (isset($_GET['status'])) echo $_GET['status'];


// Initialize the Session
session_start();
$userId = $_SESSION['username'];
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php?status=login_to_add_property");
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

	<title>Estate Properties</title>

    <!-- CSS LINK -->
	<link href="css/create.css" rel="stylesheet">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" href="../img/favi.png" sizes="16x16" type="image/png">
</head>

<body>

    <!-- Hook Area -->
    <div class="hook">
        <p>Looking to buy or sell? You are at the right place.</p>
        <p id="remove">Real Estate || Property sales || Property Rentals</p>
        <p id="remove">Helpdesk: web4citizen@gmail.com</p>
    </div>


    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <a style="font-size:25px;font-family: 'Satisfy', cursive; "class="navbar-brand" href="../index.php">Estate Properties</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button> 
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link active" href="../index.php">Home <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="../login/logout.php">Log Out</a>
            </div>
          </div>
        </nav>

    
    <!-- Section One -->
	<div class="container">
    <div class="wrapper">

        <!-- Title -->
		<h1>NEW PROPERTY</h1>
        <button style="color:yellow;" onclick="myAlert()">Info</button>
		<form action= "createdb.php" method="POST">

        <!-- Form Fields -->

        <!-- Name -->
		<input type = "text" name ="name" placeholder=" Property Name" onkeyup="lettersOnly(this)"required>

        <!-- Description -->
        <textarea cols="40" rows="5" name ="info" size="40" placeholder=" Description" style="background:none;width:100%;height:200px;font-size:18px;border-bottom:5px solid black;border-radius: 10px;margin:5px;padding:5px;" onkeyup="lettersOnly(this)" required></textarea>

        <!-- Features -->
        <textarea cols="40" rows="5" name ="features" size="40" placeholder=" Unique Features" style="background:none;width:100%;height:200px;font-size:18px;border-bottom:5px solid black;border-radius:10px;margin:5px;padding: 5px;" onkeyup="lettersOnly(this)"required></textarea>
        
        <!-- Email -->
        optional
        <input type = "email" name ="email" placeholder=" Email" onkeyup="emailOnly(this)">
        
        <!-- Phone Nos -->
        optional
        <input type = "text" name ="phone" placeholder=" Cell" onkeyup="lettersOnly(this)">
        <hr>

        <!-- Output lat $ lng -->
        <p id="demo"></p>

        <!-- Input lat $ lng -->
        optional
        <input type = "text" name ="latitude" placeholder="  Latitude" onkeyup="lettersOnly(this)">
        <input type = "text" name ="longitude" placeholder="  Longitude" onkeyup="lettersOnly(this)">
		<label for =""><br></label>
        <div class="form-group">
            <label for="exampleFormControlSelect1">Company Name</label>
            <select class="form-control" name ="id" id="exampleFormControlSelect1" required>
                <!-- Return Session UserID -->
              <option><?php echo $userId ?></option>
            </select>
        </div>

        <!-- Submit Button -->
		<button type='submit' name="submit" placeholder="Submit"><b>Submit</b></button>
		</form>
	</div>
	</div>


    <!-- SVG DESIGN -->
	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#172730" fill-opacity="1" d="M0,224L0,288L75.8,288L75.8,160L151.6,160L151.6,64L227.4,64L227.4,192L303.2,192L303.2,32L378.9,32L378.9,32L454.7,32L454.7,224L530.5,224L530.5,288L606.3,288L606.3,192L682.1,192L682.1,288L757.9,288L757.9,32L833.7,32L833.7,192L909.5,192L909.5,256L985.3,256L985.3,64L1061.1,64L1061.1,160L1136.8,160L1136.8,256L1212.6,256L1212.6,32L1288.4,32L1288.4,256L1364.2,256L1364.2,96L1440,96L1440,320L1364.2,320L1364.2,320L1288.4,320L1288.4,320L1212.6,320L1212.6,320L1136.8,320L1136.8,320L1061.1,320L1061.1,320L985.3,320L985.3,320L909.5,320L909.5,320L833.7,320L833.7,320L757.9,320L757.9,320L682.1,320L682.1,320L606.3,320L606.3,320L530.5,320L530.5,320L454.7,320L454.7,320L378.9,320L378.9,320L303.2,320L303.2,320L227.4,320L227.4,320L151.6,320L151.6,320L75.8,320L75.8,320L0,320L0,320Z"></path></svg>
	


    <!-- FOOTER -->
    <div class="footer">        
        <div class="webName">
            <!--  COMPANY/WEBSITE NAME -->
            <p>&copy;<a href="http://webcitizen.epizy.com/">Estate Properties <span>2020<span></a></p>
        </div>
    </div>


<!-- JAVASCRIPT FUNCTIONS -->


<!-- CAPTURE AND DISPLAY LONGITUDE AND LATITUDE -->
<script>
	var x = document.getElementById("demo");

	function getLocation() {
	  if (navigator.geolocation) {
	    navigator.geolocation.getCurrentPosition(showPosition);
	  } else { 
	    window.alert("Geolocation is not supported by this browser.");
	  }
	}
	function showPosition(position) {
		x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude;
	}
	// Activate Function
	getLocation()

</script>


<!-- ALERT INFO BOX -->
<script>
function myAlert() {
  alert("The Latitude and longitude below identifies your current location. Add the cordinates into specified form area if your current location is the location of the property you are selling.");
}
</script>


<!-- FUNCTION_VALIDATES USER CHARACTER INPUT -->
<script> 
function lettersOnly(input) {
    var regex = /[^a-z 0-9._,-]/gi;
    input.value = input.value.replace(regex, "");
}
</script>
<script> 
function emailOnly(input) {
    var regex = /[^a-z 0-9._,@-]/gi;
    input.value = input.value.replace(regex, "");
}
</script>

<!-- BOOTSTRAP JS CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>
