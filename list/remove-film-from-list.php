<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$film_id = $_POST['film_id'];
$list_id = $_POST['list_id'];

try {
    $user_id = $_SESSION['user']['id'];
    $sql = "SELECT id FROM list WHERE id = $list_id AND user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    $sql = "DELETE FROM listfilm WHERE film_id = $film_id AND list_id = $list_id";
    $result = mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
?>