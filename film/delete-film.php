<?php
require_once "../utils/database.php";
$id = $_POST["id"];
$sql = "DELETE FROM film WHERE id = $id";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: ../films.php");
} else {
    echo "Error: " . mysqli_error($conn);
}
?>