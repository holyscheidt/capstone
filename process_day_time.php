<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userDay = $_POST["day"];   // Get the selected day
    $userTime = $_POST["time"]; // Get the selected time

    echo "You selected: " . htmlspecialchars($userDay) . " at " . htmlspecialchars($userTime) . "<br>";

    switch ($userDay) {
        case "Monday":
            $userDay = "M";
            break;
        case "Tuesday":
            $userDay = "T";
            break;
        case "Wednesday":
            $userDay = "W";
            break;
        case "Thursday":
            $userDay = "TH";
            break;
        case "Friday":
            $userDay = "F";
            break;
        case "Saturday":
            $userDay = "SA";
            break;
        case "Sunday":
            $userDay = "SU";
            break;
        default:
            echo "Invalid day";
    }

    // Read the room list from the file (known_rooms.txt)
    $rooms = file('known_rooms.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // Convert lines into a single array of rooms
    $rooms = array_map('trim', explode(',', implode(',', $rooms)));

    // Query to find rooms that match the conditions
    $sql = "SELECT * FROM roomschedule WHERE 
                (day1 = ? OR day2 = ? OR day3 = ?) 
                AND (? BETWEEN startTime AND endTime)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }


    $stmt->bind_param("ssss", $userDay, $userDay, $userDay, $userTime);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Store booked rooms in an array
    $bookedRooms = [];
    while ($row = $result->fetch_assoc()) {
        $bookedRooms[] = $row['room'];
    }


    // Close the connection
    $stmt->close();
    $conn->close();

    // Remove booked rooms from the known_rooms list
    $availableRooms = array_diff($rooms, $bookedRooms);


    if (!empty($availableRooms)) {
        echo "<br>Available Rooms:<br>";
        foreach ($availableRooms as $room) {
            echo htmlspecialchars($room) . "<br>";
        }
    } 
    else {
        echo "<br>No available rooms.";
        }

    }
?>
