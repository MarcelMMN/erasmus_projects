<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM students WHERE email='$email' AND password='$password'";
    $result = $db->query($sql);

    if ($result && $result->num_rows > 0) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<h2>Invalid Email or Password!</h2>";
    }
}
?>