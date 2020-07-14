<?php

// 
// Include config file
// require_once "login/config.php";

// Connect to Database File
require_once 'dbConfig.php';


// Initialize Session
session_start();


// Message_Status Here:
if (isset($_GET['status'])) echo $_GET['status'];


// Fetch the marker info from the database
$result = $db->query("SELECT * FROM location");
// Fetch the info-window data from the database
$result2 = $db->query("SELECT * FROM location");
?>


<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.min.css"/>

	<title>Estate Properties</title>

    <!-- CSS FILE LINK -->
    <link href="map.css" rel="stylesheet">

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
        <a style="font-size:25px;font-family: 'Satisfy', cursive; "class="navbar-brand">Estate Properties</a>
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

        <!-- Title Area-->
        <div class="title">
            <h1 class="animate">Estate Properties</h1>
            <p>For all your Real Estate Needs</p>
        </div>


        <!-- Section Two -->

        <!-- Map -->
        <div id="map"></div>

        <!-- Property Titles -->
        <div class="property">

            <!-- USING PREPARED STATEMENTS TO DISPLAY DATA -->
            <?php
                $ssql = "SELECT id, name FROM location";
                
                mysqli_prepare($db, $ssql) or die(mysqli_error($db));

                // CREATE PREPARED STATEMENTS
                $sresult = mysqli_prepare($db, $ssql);
                mysqli_stmt_bind_result($sresult, $id, $name);
                mysqli_stmt_execute($sresult);
                while (mysqli_stmt_fetch($sresult)) {

                // FETCH PROPRTY TITLES
                echo "<div class ='propertyNames'><a href='pages.php?name=" . $name . "' >" . $name . "</a></div>";
                }
            ?>
        </div>


        <!-- Section Three -->

        <!-- Image Collage -->
        <div class="collage">
            <img src = "img/home1.jpg" alt= "1" >
            <img src = "img/home2.jpg" alt= "2" >
            <img src = "img/home3.jpg" alt= "3" >
            <img src = "img/home4.jpg" alt= "4" >
            <img src = "img/home5.jpg" alt= "5" > 

            <img src = "img/home5.jpg" alt= "5" >
            <img src = "img/home4.jpg" alt= "4" > 
            <img src = "img/home3.jpg" alt= "3" >
            <img src = "img/home2.jpg" alt= "2" >
            <img src = "img/home1.jpg" alt= "1" >
        </div>


        <!-- Section Four -->

        <!-- Slideshow container -->
        <div class="slideshow-container">
          <!-- Full-width slides/quotes -->
          <div class="mySlides">
            <q>Buy land, they’re not making it anymore.</q>
            <p class="author">- Mark Twain</p>
          </div>

          <div class="mySlides">
            <q>Don’t wait to buy real estate. Buy real estate and wait.</q>
            <p class="author">- Will Rogers</p>
          </div>

          <div class="mySlides">
            <q>Find out where the people are going and buy the land before they get there.</q>
            <p class="author">- William Penn Adair</p>
          </div>

          <!-- Next/prev buttons -->
          <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
          <a class="next" onclick="plusSlides(1)">&#10095;</a>
        </div>

        <!-- Dots/bullets/indicators -->
        <div class="dot-container">
          <span class="dot" onclick="currentSlide(1)"></span>
          <span class="dot" onclick="currentSlide(2)"></span>
          <span class="dot" onclick="currentSlide(3)"></span>
        </div>
    </div>


    <!-- Footer Area -->
    <div class="footer">  

        <div class="smediaFooter">
              <!-- ADDD SOCIAL MEDIA LNKS -->
            <p>Connect with us:</p>
            <a href="#"><img src="img/facebook.png" alt="facebook"></a>
            <a href="#"><img src="img/twitter.png" alt="twitter"></a>
            <a href="#"><img src="img/linkedin.png" alt="linkedin"></a>
        </div>

        <div class="webName">
            <!--COMPANY/WEBSITE NAME -->
            <p>&copy;<a href="http://webcitizen.epizy.com/">Estate Properties <span>2020<span></a></p>
        </div>

        <div class="create">
            <a href="create/create.php"><button type="button"><b>ADD<br>PROPERTY</b></button></a>
        </div>
    </div>



<!-- JAVASCRIPT BEGINS -->
<script>
// DISPLAY MAP MARKERS AND INFO
function initMap() {
    var options = {
        zoom: 4,
        center: {lat:-22.647889, lng:17.118677}
    }
                    
    // Map longitude and Latitude
    var map = new
    google.maps.Map(document.getElementById('map'), options);
        
    // Multiple markers location, latitude, and longitude
    var markers = [
        <?php if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo '["'.$row['name'].'", '.$row['latitude'].', '.$row['longitude'].'],';
            }
        }
        ?>
    ];
                        
    // Info window content
    var infoWindowContent = [
        <?php if($result2->num_rows > 0){
            while($row = $result2->fetch_assoc()){ ?>
                ['<div class="info_content">' +
                '<a href="pages.php?name=<?php echo $row['name']; ?>"><?php echo $row['name']; ?>' +
                '</a></div>'],
        <?php }
        }
        ?>
    ];
        
    // Add multiple markers to map
    var infoWindow = new google.maps.InfoWindow(), marker, i;
    
    // Place each marker on the map  
    for( i = 0; i < markers.length; i++ ) {
        var position = new google.maps.LatLng(markers[i][1], markers[i][2]);

        marker = new google.maps.Marker({
            position: position,
            map: map,
            icon: "http://maps.google.com/mapfiles/ms/icons/blue-dot.png",
            title: markers[i][0]
        });
        
        // Add info window to marker    
        google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
                infoWindow.setContent(infoWindowContent[i][0]);
                infoWindow.open(map, marker);
            }
        })(marker, i));

    }
}


// GOOGLE MAPS API KEY
</script>
<script async defer
  src="https://maps.googleapis.com/maps/api/js?key= &callback=initMap">
</script>



<!-- LOAD TITLE ANIMATION -->
<script>
const element = document.querySelector('.animate');
element.classList.add('animate__animated', 'animate__flipInX');
</script>



<!-- SLIDER JS FUNCTION -->
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";
    }
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
}
</script>



<!-- BOOTSTRAP JS CDN -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>


</body>
</html>
