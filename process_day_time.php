<html lang="en">

<header class=header>
        <img src="maryville.jpeg" alt="Logo" class="header-logo">
</header>

<head>
    <title>Available Rooms</title>
    <link rel="stylesheet" href="styles.css">
</head>

<?php

include 'db.php'; // attaches database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userDay = $_POST["day"];  
    $timeOption = $_POST["time-option"]; // single or range

    echo "<div class='selection'>You selected: <strong>" . htmlspecialchars($userDay) . "</strong></div>";

    // change names to match db 
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
            echo "<div class='error'>Invalid day</div>";
    }

    // read the room list to compare against later
    $rooms = file('known_rooms.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $rooms = array_map('trim', explode(',', implode(',', $rooms)));

    // Prepare SQL query based on time option
    if ($timeOption === "single") {
        $userTime = $_POST["time"]; // get the single time
        echo "<div class='selection'>At time: <strong>" . htmlspecialchars($userTime) . "</strong></div>";

        $sql = "SELECT * FROM roomschedule WHERE 
                    (day1 = ? OR day2 = ? OR day3 = ?) 
                    AND (? BETWEEN startTime AND endTime)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $userDay, $userDay, $userDay, $userTime);

        
    } else if ($timeOption === "range") {
        $startTime = $_POST["start-time"]; // get the start time
        $endTime = $_POST["end-time"]; // get the end time
        echo "<div class='selection'>From: <strong>" . htmlspecialchars($startTime) . "</strong> to <strong>" . htmlspecialchars($endTime) . "</strong></div>";

        $sql = "SELECT * FROM roomschedule WHERE 
                    (day1 = ? OR day2 = ? OR day3 = ?) 
                    AND (startTime < ? AND endTime > ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssss", $userDay, $userDay, $userDay, $endTime, $startTime);
    }

    // Execute the query
    if (!$stmt) {
        die("<div class='error'>SQL Error: " . $conn->error . "</div>");
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Store the taken rooms in another array
    $bookedRooms = [];
    while ($row = $result->fetch_assoc()) {
        $bookedRooms[] = $row['room'];
    }

    // Close connection
    $stmt->close();
    $conn->close();

    // Subtract the taken rooms from the array of all the rooms
    $availableRooms = array_diff($rooms, $bookedRooms);

    // Display the available rooms
    if (!empty($availableRooms)) {
        echo "<div class='available-rooms'><h2>Available Rooms:</h2><ul>";
        $availableRooms = array_filter($availableRooms); // Filter out empty values
        foreach ($availableRooms as $room) {
            echo "<li>" . htmlspecialchars($room) . "</li>";
        }
        echo "</ul></div>";
    } else {
        echo "<div class='no-rooms'>No available rooms.</div>";
    }
}
?>
<html>
    <a href="index.php" class="button">Back</a>
</html>
