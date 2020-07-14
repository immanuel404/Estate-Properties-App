<?php 

// IMAGE DELETE


// Initialize the session
session_start();


require_once '../dbConfig.php';


$page_id = mysqli_real_escape_string($db, $_POST['page_id']);
$id = mysqli_real_escape_string($db, $_POST['id']);


	$sql = "DELETE from images where id= ? ";

	$stmt = mysqli_stmt_init($db);
	if (!mysqli_stmt_prepare($stmt, $sql)) {
		echo "SQL error";
	} else {
		mysqli_stmt_bind_param($stmt, "s", $id);
		mysqli_stmt_execute($stmt);
	}
	header("Location: edit.php?name=$page_id");

?>

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