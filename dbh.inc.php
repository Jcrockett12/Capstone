<?php

$host = "mysql.specialoccasionmessagesender.xyz";
$dbUsername = "soms";
$dbPassword = "Korrabear1205$";
$dbName = "soms";


$conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);

if (!$conn){
	die("Connection failed: " . mysqli_connect_error());
}