<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$director_id = $_POST['director_id'];
$film_id = $_POST['film_id'];

try {
    $sql = "UPDATE film SET director_id = $director_id WHERE id = $film_id";
    $result = mysqli_query($conn, $sql);
    header("Location: " . $_SERVER['HTTP_REFERER']);
} catch (Exception $e) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
}

?>