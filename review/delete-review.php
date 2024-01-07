<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$film_id = $_POST["film_id"];
$user_id = $_SESSION['user']['id'];

if ($user_id != $_SESSION['user']['id']) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    return;
}

$sql = "DELETE FROM review WHERE film_id = $film_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
if ($result) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>