<?php
require_once "../utils/requires-admin.php";
require_once "../utils/database.php";
$id = $_POST["id"];
$sql = "DELETE FROM song WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../songs.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>