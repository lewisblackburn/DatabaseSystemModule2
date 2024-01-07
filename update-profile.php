<?php
require_once "utils/requires-user.php";
require_once "utils/database.php";
$id = $_SESSION["user"]["id"];
$fullName = $_POST["full_name"];
$email = $_POST["email"];
$sql = "UPDATE user SET full_name = '$fullName', email = '$email' WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: profile.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>