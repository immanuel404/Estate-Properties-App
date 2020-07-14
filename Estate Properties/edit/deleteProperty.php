<?php

// PROPERTY LISTING DELETE


// Connect to Database
require_once '../dbConfig.php';


$select = "DELETE from location where id='".$_GET['del_id']."'";
$query = mysqli_query($db, $select) or die($select);
$name_rs = mysqli_fetch_assoc($query);
header ("Location: ../index.php");

?>