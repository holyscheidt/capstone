<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $day = $_POST["day"];   // Get the selected day
    $time = $_POST["time"]; // Get the selected time

    echo "You selected: " . htmlspecialchars($day) . " at " . htmlspecialchars($time);
}
?>