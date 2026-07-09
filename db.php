<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "form";

$db = new mysqli($host, $user, $password, $database);

if ($db->connect_error) {
    die("Błąd połączenia z bazą: " . $db->connect_error);
}
?>