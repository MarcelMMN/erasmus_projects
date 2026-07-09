<?php

// Include the database connection
include "db.php";

$row = null;

// Check if the ID is received from view_students.php
if(isset($_GET['id'])){

    // Get the ID
    $id = $_GET['id'];

    // Retrieve the student's information using a prepared statement
    $sql = "SELECT * FROM students WHERE id=?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Store the student information
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
    }else{
        echo "<h2>Student Not Found!</h2>";
        exit();
    }

    $stmt->close();
}

// Check if the Update button is clicked
if(isset($_POST['update'])){

    // Receive updated values
    $id = $_POST['id'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL query to update the student using a prepared statement
    $sql = "UPDATE students
            SET fullname=?,
                email=?,
                phone=?
            WHERE id=?";

    $stmt = $db->prepare($sql);
    $stmt->bind_param("sssi", $fullname, $email, $phone, $id);

    if($stmt->execute()){

        echo "<h2>Student Updated Successfully!</h2>";

        // Reload the updated student information
        $sql = "SELECT * FROM students WHERE id=?";
        $stmt2 = $db->prepare($sql);
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $result = $stmt2->get_result();
        $row = $result->fetch_assoc();
        $stmt2->close();

    }else{

        echo "<h2>Error: ".$db->error."</h2>";

    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>Update Student</title>

</head>

<body>

<h2>Update Student Information</h2>

<?php if($row): ?>

<!-- Update Form -->
<form method="POST">

    <!-- Hidden ID field, needed so the update query knows which row to update -->
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">

    <!-- Student ID (display only, not editable) -->
    <label>Student ID</label><br>
    <input type="text" name="student_id"
    value="<?php echo htmlspecialchars($row['student_id']); ?>" readonly><br><br>

    <!-- Full Name -->
    <label>Full Name</label><br>
    <input type="text" name="fullname"
    value="<?php echo htmlspecialchars($row['fullname']); ?>" required><br><br>

    <!-- Email -->
    <label>Email</label><br>
    <input type="email" name="email"
    value="<?php echo htmlspecialchars($row['email']); ?>" required><br><br>

    <!-- Phone -->
    <label>Phone Number</label><br>
    <input type="text" name="phone"
    value="<?php echo htmlspecialchars($row['phone']); ?>" required><br><br>

    <!-- Update Button -->
    <input type="submit" name="update" value="Update Student">

</form>

<?php endif; ?>

<br>

<a href="view_students.php">Back to Student List</a>

</body>

</html>

<?php

// Close the database connection
$db->close();

?>