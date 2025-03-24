<!DOCTYPE html>

<?php
include 'db.php';  // connect to database
?>

<html lang="en">
<head>
    <title>Maryville Room Schedule<</title>
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

    <label for="time">Select Time:</label>
    <!-- time input -->
    <input type="time" id="time" name="time" required>

    <br><br>

    <button type="submit">Submit</button>
</form>

<?php

    //displaying full table
    $sql = "SELECT className, day1, day2, day3, startTime, endTime, room FROM roomSchedule";
    $result = $conn->query($sql);
?>  

    <table>
    <tr>
        <th>Classroom Number</th>
        <th>Day 1</th>
        <th>Day 2</th>
        <th>Day 3</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Room Number</th>
    </tr>


    
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["className"]; ?></td>
        <td><?php echo $row["day1"]; ?></td>
        <td><?php echo $row["day2"]; ?></td>
        <td><?php echo $row["day3"]; ?></td>
        <td><?php echo $row["startTime"]; ?></td>
        <td><?php echo $row["endTime"]; ?></td>
        <td><?php echo $row["room"]; ?></td>
    </tr>
    <?php } ?>

</body>
</html>
