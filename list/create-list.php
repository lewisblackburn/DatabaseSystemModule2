<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$user_id = $_SESSION['user']['id'];
$name = $_POST['name'];
$sql = "INSERT INTO list (user_id, name) VALUES ($user_id, '$name')";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../profile.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>