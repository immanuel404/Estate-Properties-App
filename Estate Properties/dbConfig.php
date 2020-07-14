<?php
// Database configuration
$dbHost     = "sql202.epizy.com";
$dbUsername = "epiz_25982299";
$dbPassword = "gm3B5wyZ6kV";
$dbName     = "epiz_25982299_properties";

// Create database connection
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

?>