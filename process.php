<?php
    include 'db.php'; // Connect to database

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST["name"];
        $email = $_POST["email"];
        $message = $_POST["message"];

        // Insert data into database
        $sql = "INSERT INTO users (name, email, message) VALUES ('$name', '$email', '$message')";
    
            if ($conn->query($sql) === TRUE) {
                echo "Data successfully saved!";
                echo "<br><a href='view.php'>View Data</a>";
            } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
?>