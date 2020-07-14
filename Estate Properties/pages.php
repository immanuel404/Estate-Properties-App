<?php


// Include config file
require_once "login/config.php";


// Connect to Database File
require_once 'dbConfig.php';


// Initialize the session
session_start();


// Check if property names has been passed to the URL
if (isset($_GET['name'])) {
	$NAME = mysqli_real_escape_string($db, $_GET['name']);

	// <!-- RETURN DATABASE PROPERTAIES -->
    $page_sql = "SELECT * FROM location WHERE name = '$NAME' ";
    $page_query = mysqli_query ($db, $page_sql);
    $page_rs = mysqli_fetch_assoc($page_query);

} else {
header('location: index.php');
}
?>


<!DOCTYPE html>
<html>
<head>

	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- BOOTSTRAP -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- SOCIAL SHARE CDN-->
	<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5ed4a54b606f5b0012eb59dd&product=inline-share-buttons" async="async"></script>
	
	<title>Estate Properties</title>

	<!-- CSS LINK -->
	<link href="page.css" rel="stylesheet">

	<!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css2?family=Satisfy&display=swap" rel="stylesheet">

    <!-- FAVICON -->
    <link rel="icon" href="img/favi.png" sizes="16x16" type="image/png">
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
        <a style="font-size:25px;font-family: 'Satisfy', cursive; "class="navbar-brand" href="index.php">Estate Properties</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav ml-auto">
              <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
              <a class="nav-item nav-link" href="create/create.php">Create</a>
              <a class="nav-item nav-link" href="login/register.php">Register</a>
              <a class="nav-item nav-link" href="login/login.php">Login</a>
              <a class="right-nav-item nav-link" href="login/logout.php">Logout</a>
            </div>
          </div>
        </nav> 


  	<!-- Section One -->
	<div class="container">

		<!-- TITLE AREA -->
        <div class="title">	

    	<!-- CHECK IF USER IS ALLOWED TO EDIT PAGE  -->
		<?php
		if (isset($_SESSION['username'])) {
			$userId = $_SESSION['username'];
			$new = $page_rs['name'];
			if ($page_rs['userid'] == $userId) {

			// DISPLAY EDIT LINK
			echo "<p><a href='edit/edit.php?name=".$new."'>Edit</a></p>";
			}
		}
		?>

			<!-- FETCH TITLE -->
            <h1><?php echo $page_rs['name'] ?></h1>
            <p></p>
        </div>


        <!-- Section Two -->

        <!-- PROPERTY-INFO AREA -->
        <div class="infoArea">

        	<!-- Property Description Area -->
	        <div class="describe">
	        	<h3>Description</h3>
	        	<h5><?php echo $page_rs['info'] ?></h5>	
				<p>Contact: <?php echo $page_rs['phone'] ?></p>
				<p>Email: <?php echo $page_rs['email'] ?></p>
	        </div>

	        <!-- Property Features area -->
	        <div class="features">
	        	<h3>Features</h3>
	        	<h5><?php echo $page_rs['features'] ?></h5>
	        </div>
	    </div>


	    <!-- Section Three -->

	    <!-- Title -->
	    <h2><b>PROPERTY IMAGES</b></h2>

	    <div class="flex-container">

	    <!-- RETURN IMAGES -->
	    <?php
	     	$pageId = $page_rs['id'];

	        $name_sql = "SELECT * FROM images WHERE image_id = '$pageId' ";
	        $name_query = mysqli_query ($db, $name_sql);
	        $name_rs = mysqli_fetch_assoc($name_query);
	        do { ?>
	            <div class="images"><img src="uploads/<?php echo $name_rs['file_name'] ?>" alt="img"></div>
	            <?php
	            } while ($name_rs = mysqli_fetch_assoc($name_query))
	        ?>
	    </div>


	    <!-- Section Four -->

		<div class="property">

		<!-- DISPLAY OTHER COMPANY PROPERTIES -->
	    <?php
	    	$usserId = $page_rs['userid'];

	        $usql = "SELECT name FROM location WHERE userid = '$usserId' ";
	        $owner_query = mysqli_query ($db, $usql);
	        $owner_rs = mysqli_fetch_assoc($owner_query);
	        do { ?>
	        	<div class ='propertyNames'><a href='pages.php?name=<?php echo $owner_rs['name'] ?>'><?php echo $owner_rs['name'] ?></a></div>
	        	<?php
	            } while ($owner_rs = mysqli_fetch_assoc($owner_query))
	        ?>
		</div>

		<!-- SOCIAL SHARE LINKS-->
	    <div style="margin:20px;"class="sharethis-inline-share-buttons"></div>
	</div>


	<!-- Footer Area -->
    <div class="footer">        
        <div class="webName">
            <!--  COMPANY/WEBSITE NAME -->
            <p>&copy;<a href="http://webcitizen.epizy.com/">Estate Properties <span>2020<span></a></p>	
        </div>
    </div>


<!-- Bootstrap CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>