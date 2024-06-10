<?php
include('Connection.php');

$dbname = "eto_baza";
$host = "localhost";
$user = "root";
$password = "28051980MySQL+";

$connection = new Connection($dbname, $host, $user, $password);
$connection->connectDb();
?>