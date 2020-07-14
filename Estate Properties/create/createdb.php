<!-- // INSERTING DATA FROM FORM INTO DATABASE -->
<?php
	require_once '../dbConfig.php';


if (isset($_POST['submit'])) {

    $userid = mysqli_real_escape_string($db, $_POST['id']);
    $info = mysqli_real_escape_string($db, $_POST['info']);
    $features = mysqli_real_escape_string($db, $_POST['features']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $phone = mysqli_real_escape_string($db, $_POST['phone']);
    $latitude = mysqli_real_escape_string($db, $_POST['latitude']);
    $longitude = mysqli_real_escape_string($db, $_POST['longitude']);


    // Prepare a select statement
    $sql_u = "SELECT * FROM location WHERE name = ? ";

    if($stmt = mysqli_prepare($db, $sql_u)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_name);
        
        // Set parameters
        $param_name = trim($_POST["name"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            /* store result */
            mysqli_stmt_store_result($stmt);
            
            if(mysqli_stmt_num_rows($stmt) > 0){
                header("Location: create.php?status=Sorry_name already taken");
            } else{
                $name = mysqli_real_escape_string($db, $_POST['name']);

                $sql = "INSERT INTO location (userid, name, info, features, email, phone, latitude, longitude) VALUES (?,?,?,?,?,?,?,?);";

                $stmt = mysqli_stmt_init($db);
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    echo "SQL error";
                } else {
                    mysqli_stmt_bind_param($stmt, "ssssssss", $userid, $name, $info, $features, $email, $phone, $latitude, $longitude);
                    mysqli_stmt_execute($stmt);
                }
                header("Location: ../index.php?status=submission_successfull");
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

        // Close statement
        mysqli_stmt_close($stmt);
    }
}

?>

</body>
</html>
<!-- CREATE TABLE location (
	id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
	userid varchar(100) NOT NULL,
	name varchar(100) NOT NULL,
	info varchar(255) NOT NULL,
	features varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	phone varchar(20) NOT NULL,
	latitude varchar(20) NOT NULL,
	longitude varchar(20) NOT NULL,
	created_at DATETIME DEFAULT CURRENT_TIMESTAMP
); -->



<!-- ERROR MESSAGE AREA -->
<!DOCTYPE html>
<html>
<head>
    <title>Estate Properties</title>
    <!-- FAVICON -->
    <link rel="icon" href="../img/favi.png" sizes="16x16" type="image/png">
</head>
<body>

<!-- CLASS DOM -->
<div class="info"></div>

<!-- SVG DESIGN -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 319"><path fill="#3D5B6B" fill-opacity="1" d="M0,32L48,48C96,64,192,96,288,101.3C384,107,480,85,576,80C672,75,768,85,864,128C960,171,1056,245,1152,277.3C1248,309,1344,299,1392,293.3L1440,288L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>
</body>
</html>

<style>
html {
    margin: 0;
    padding: 0;
    background-color: lightblue;
    overflow: hidden;
}
.info {
    background: url("../img/info.png") no-repeat;
    background-size: cover;
    width: 150px;
    height: 150px;
    margin: 20px auto;
}
svg {
    position: absolute;
    right: 0;
    bottom: 0;
}
</style>