<?php
// Get user input (day and time)
$userDay = $_POST['day'];  // Assuming you're receiving 'day' via a POST request
$userTime = $_POST['time'];  // Assuming you're receiving 'time' via a POST request

// Read the room list from the file (known_rooms.txt)
$rooms = file('known_rooms.txt', FILE_IGNORE_NEW_LINES);  // Read each room into an array

// Database connection (assuming you're using MySQL)
$mysqli = new mysqli('localhost', 'username', 'password', 'database_name');

// Check the connection
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Query to find rooms that match the conditions
$sql = "SELECT * FROM rooms WHERE 
            (day = ? OR day = ? OR day = ?) AND
            (time > ? AND time < ?)";

// Prepare the statement
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sssss", $userDay, $userDay, $userDay, $userTime, $userTime);

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Check if any rooms match the conditions
if ($result->num_rows > 0) {
    // Room found, display it
    while ($row = $result->fetch_assoc()) {
        echo "Room: " . $row['room_name'] . " is available.";
    }
} else {
    echo "No rooms available for the selected day and time.";
}

// Close the connection
$stmt->close();
$mysqli->close();
?>