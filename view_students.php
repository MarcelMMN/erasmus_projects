<?php
include "db.php";

if (isset($_POST['student_id']) && $_POST['student_id'] != "") {
    $student_id = $_POST['student_id'];
    $sql = "SELECT * FROM students WHERE student_id='$student_id'";
} else {
    $sql = "SELECT * FROM students";
}

$result = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Students</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <h2>Student List</h2>

    <form method="post">
        <label>Search by Student ID</label><br><br>
        <input type="text" name="student_id">
        <input type="submit" value="search">
    </form>

    <table>
    <tr>
        <th>Full name</th>
        <th>Student ID</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Department</th>
        <th>Semester</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>

    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
    ?>
    <tr>
        <td><?php echo $row['fullname']; ?></td>
        <td><?php echo $row['student_id']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['phone']; ?></td>
        <td><?php echo $row['department']; ?></td>
        <td><?php echo $row['semester']; ?></td>
        <td>
            <a href="update.php?id=<?php echo $row['id']; ?>">Update</a>
        </td>
        <td>
            <a class="delete" href="delete.php?id=<?php echo $row['id']; ?>">Delete</a>
        </td>
    </tr>
    <?php
        }
    } else {
    ?>
    <tr>
        <td colspan="8">No Students Found</td>
    </tr>
    <?php
    }
    $db->close();
    ?>
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>