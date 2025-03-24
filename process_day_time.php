<?php

include 'db.php'; //attaches database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userDay = $_POST["day"];   // post the selected day
    $userTime = $_POST["time"]; // post the selected time

    echo "You selected: " . htmlspecialchars($userDay) . " at " . htmlspecialchars($userTime) . "<br>";

    //submissions are in full days so they need to be changed to abbreviations in order to search the database
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

    // read the room list to compare against later
    $rooms = file('known_rooms.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // make an array with all the rooms
    $rooms = array_map('trim', explode(',', implode(',', $rooms)));

    // find all the rooms that are taken at the time that the user searched for
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

    //store the taken rooms in another array
    $bookedRooms = [];
    while ($row = $result->fetch_assoc()) {
        $bookedRooms[] = $row['room'];
    }


    //close connection
    $stmt->close();
    $conn->close();

    //subtract the taken rooms from the array of all the rooms
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
