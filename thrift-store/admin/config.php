<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "thrift_store";
	
$conn = mysqli_connect("localhost", "root", "", "thrift_store");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

?>