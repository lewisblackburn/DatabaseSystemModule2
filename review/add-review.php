<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$film_id = $_POST['film_id'];
$user_id = $_SESSION['user']['id'];
$rating = $_POST['rating'];
$comment = $_POST['comment'];

try {
    $sql = "INSERT INTO review (film_id, user_id, rating, comment) VALUES ($film_id, $user_id, $rating, '$comment')";
    $result = mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}
?>