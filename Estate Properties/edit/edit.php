<?php 


// Include config file
// require_once "login/config.php";


// Connect to Database
require_once '../dbConfig.php';


// Initialize the Session
session_start();


// Check if Property Name is in URL
if (isset($_GET['name'])) {
	$NAME = mysqli_real_escape_string($db, $_GET['name']);

	// <!-- RETURN DATABASE PROPERTIES -->
    $page_sql = "SELECT * FROM location WHERE name = '$NAME' ";
    $page_query = mysqli_query ($db, $page_sql);
    $page_rs = mysqli_fetch_assoc($page_query);
} else {
header('location: ../index.php');
}


// Check for Session Present
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../index.php");
    exit;
}


// Check for Session ID
$userId = $_SESSION['username'];
	
if ($page_rs['userid'] !== $userId) {
	header('location: ../index.php');
}
?>


<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	
	<title>Estate Properties</title>

	<!-- CSS LINK -->
	<link href="css/edit.css" rel="stylesheet">

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


    <!-- Navbar Area -->
    <nav class="navbar navbar-expand-lg navbar navbar-dark bg-dark">
        <a style="font-size:25px;font-family: 'Satisfy', cursive; "class="navbar-brand" href="../index.php">Estate Properties</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link active" href="../index.php">Home <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="../create/create.php">Create</a>
              <a class="nav-item nav-link" href="../login/register.php">Register</a>
              <a class="nav-item nav-link" href="../login/login.php">Login</a>
              <a class="right-nav-item nav-link" href="../login/logout.php">Logout</a>
            </div>
          </div>
        </nav>


	<div class="container">

		<!-- Section One -->
		<div class="propertyDelete">
			<h1>Edit Property Information</h1>

			<!-- Function to Delete Property -->
			<input type="button" onClick="deleteProperty(<?php echo $page_rs['id']; ?>)" name="Delete" value="Delete Property">
			<!-- Javascript function for deleting data -->
			<script>
			function deleteProperty(delid) {
				if(confirm("Are you sure you want to delete this property!")) {
					window.location.href='deleteProperty.php?del_id=' +delid+'';
					return true;
				}
			} 
			</script>
		</div>


		<!-- Section Two -->
		
		<!-- FORM EDIT -->
		<div class="formEdit">
		<form action= "editdb1.php" method="POST">

		<!-- Edit Name -->
		<p>Property Name:</p>
		<input type = "text" name ="name" value="<?php echo $page_rs['name'] ?>" onkeyup="lettersOnly(this)">

		<!-- Edit Description -->
		<p><br>Property Description:</p>
		<textarea cols="40" rows="5" name ="info" size="40" value="<?php echo $page_rs['info'] ?>" onkeyup="lettersOnly(this)" style="background: none;width:100%;height:200px;font-size:18px;border-bottom:5px solid black;border-right:5px solid black;margin:5px;padding: 5px;"></textarea>

		<!-- Edit Features -->
		<p><br>Property Features:</p>
        <textarea cols="40" rows="5" name ="features" size="40" value="<?php echo $page_rs['features'] ?>" onkeyup="lettersOnly(this)" style="background: none;width:100%;height:200px;font-size:18px;border-bottom:5px solid black;border-right: 5px solid black;margin:5px;padding: 5px;"></textarea>
        
        <!-- Edit Email -->
        <p><br>email:</p>
        <input type = "email" name ="email" value="<?php echo $page_rs['email'] ?>" onkeyup="lettersOnly(this)">

        <!-- Edit Cell No -->
        <p>cell:</p>
        <input type = "text" name ="phone" value="<?php echo $page_rs['phone'] ?>" onkeyup="lettersOnly(this)">
        <hr>

        <!-- Edit Latitude and Longitude --> 
        <p>latitude:</p>
        <input type = "text" name ="latitude" value="<?php echo $page_rs['latitude'] ?>" onkeyup="lettersOnly(this)">

        <p>longitude:</p>
        <input type = "text" name ="longitude" value="<?php echo $page_rs['longitude'] ?>" onkeyup="lettersOnly(this)">
		
		<!-- Collect Page Id -->
		<div class="form-group">
		    <label for="exampleFormControlSelect1"></label>
		    <select class="form-control" name ="id" id="exampleFormControlSelect1" required>
		      <option><?php echo $page_rs['id'] ?></option>
		    </select>
		</div>

		<!-- Submit Button -->
		<label for =""><br></label>
		<button type='submit' name="submit" placeholder="Submit"><b>Update</b></button>
		</form>
		</div>

		<!-- IMAGE UPLOAD -->
		<div class="imageUpload">
			<form action="editdb2.php" method="POST" enctype="multipart/form-data">

		    <h3>Select Image Files to Upload:</h3>
		    <input type="file" name="file" multiple >
		    <input type="submit" name="submit" value="UPLOAD">

		    <!-- Collect Page_ID and Page_Name -->
		    <div class="form-group">
			    <label for="exampleFormControlSelect1"></label>
			    <select class="form-control" name ="id" id="exampleFormControlSelect1" required>
			      <option><?php echo $page_rs['id'] ?></option>
			    </select>
			</div>
			<div class="form-group">
			    <label for="exampleFormControlSelect1"></label>
			    <select class="form-control" name ="page_id" id="exampleFormControlSelect1" required>
			      <option><?php echo $page_rs['name']; ?></option>
			    </select>
			</div>
			</form>
		</div>
	</div>


	<!-- Section Three -->

	<!-- RETURN IMAGES -->
	<div class="imageArea">
    <?php
    	$pageId = $page_rs['id'];

        $name_sql = "SELECT * FROM images WHERE image_id = '$pageId' ";
        $name_query = mysqli_query ($db, $name_sql);
        $name_rs = mysqli_fetch_assoc($name_query);
        do { ?>

		<!-- Delete IMAGES -->
		<form action="delete.php" method="POST">
			<input type="submit" name="submit" value="DELETE">
		    <div class="form-group">
			    <label for="exampleFormControlSelect1"></label>
			    <select class="form-control" name ="id" id="exampleFormControlSelect1" required>
			      <option><?php echo $name_rs['id']; ?></option>
			    </select>
			</div>
		    <div class="form-group">
			    <label for="exampleFormControlSelect1"></label>
			    <select class="form-control" name ="page_id" id="exampleFormControlSelect1" required><option><?php echo $page_rs['name']; ?></option>
			    </select>
			</div><br>
		</form>
		
		<!-- Display Images -->
		<div class="images"><img src="../uploads/<?php echo $name_rs['file_name'] ?>" alt="img"></div>

		<?php
        	} while ($name_rs = mysqli_fetch_assoc($name_query))
    	?>
    </div>


    <!-- Footer Area -->
    <div class="footer">        
        <div class="webName">
            <!--  COMPANY/WEBSITE NAME -->
            <p>&copy;<a href="http://webcitizen.epizy.com/">Estate Properties <span>2020<span></a></p>
        </div>
    </div>



<!-- Input Validation Check-->
<script>
function lettersOnly(input) {
    var regex = /[^a-z 0-9.,-]/gi;
    input.value = input.value.replace(regex, "");
}
</script>


<!-- Bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>
</html>

