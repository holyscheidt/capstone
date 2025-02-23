<?php
    $servername = "localhost";
    $username = "root"; // Default XAMPP username
    $password = ""; 
    $database = "498db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }
?>
