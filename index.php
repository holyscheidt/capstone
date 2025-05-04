<!DOCTYPE html>

<?php
include 'db.php';  // connect to database
?>

<html lang="en">

<header class=header>
        <img src="maryville.jpeg" alt="Logo" class="header-logo">
</header>

<head>
    <title>Maryville Room Schedule</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="styles.css">
    <script>
        // JavaScript to toggle between single time and time range inputs
        function toggleTimeInput() {
            const singleTimeInput = document.getElementById('single-time-input');
            const timeRangeInput = document.getElementById('time-range-input');
            const singleTimeRadio = document.getElementById('single-time');
            
            if (singleTimeRadio.checked) {
                singleTimeInput.style.display = 'block';
                timeRangeInput.style.display = 'none';
            } else {
                singleTimeInput.style.display = 'none';
                timeRangeInput.style.display = 'block';
            }
        }
    </script>
</head>
<body>
<h1>Maryville Room Schedule</h1>

<form action="process_day_time.php" method="post">  
    <!-- calls the processing php file that does the search -->
    <label for="day">Select Day of the Week:</label>

    <!-- select menu-->
    <select id="day" name="day" required>
        <option value="Monday">Monday</option>
        <option value="Tuesday">Tuesday</option>
        <option value="Wednesday">Wednesday</option>
        <option value="Thursday">Thursday</option>
        <option value="Friday">Friday</option>
        <option value="Saturday">Saturday</option>
        <option value="Sunday">Sunday</option>
    </select>

    <br><br>

    <!-- radio buttons.  choose form type  -->
    <label>
        <input type="radio" id="single-time" name="time-option" value="single" checked onclick="toggleTimeInput()"> Search by Single Time
    </label>
    <label>
        <input type="radio" id="time-range" name="time-option" value="range" onclick="toggleTimeInput()"> Search by Time Range
    </label>

    <br><br>

    <!-- single -->
    <div id="single-time-input">
        <label for="time">Select Time:</label>
        <input type="time" id="time" name="time">
    </div>

    <!-- range -->
    <div id="time-range-input" style="display: none;">
        <label for="start-time">Start Time:</label>
        <input type="time" id="start-time" name="start-time">
        <br><br>
        <label for="end-time">End Time:</label>
        <input type="time" id="end-time" name="end-time">
    </div>

    <br><br>

    <button type="submit">Submit</button>
</form>

</body>
</html>
