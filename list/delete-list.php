<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$id = $_POST["list_id"];
$sql = "DELETE FROM list WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../profile.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>