<!DOCTYPE html>

<html lang="en">
<head>
    <title>Maryville Room Schedule<</title>
</head>
<body>
<h1>Maryville Room Schedule</h1>

<form action="process_day_time.php" method="post">
    <label for="day">Select Day of the Week:</label>
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
    <input type="time" id="time" name="time" required>

    <br><br>

    <button type="submit">Submit</button>
</form>



    <table>
    <tr>
        <th>Classroom Number</th>
        <th>Date</th>
        <th>Time</th>
        <th>Day of Week</th>
    </tr>


    
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row["day_of_week"]; ?></td>
        <td><?php echo $row["classroom_number"]; ?></td>
        <td><?php echo $row["date"]; ?></td>
        <td><?php echo $row["start_time"]; ?></td>
        <td><?php echo $row["end_time"]; ?></td>
    </tr>
    <?php } ?>

</body>
</html>