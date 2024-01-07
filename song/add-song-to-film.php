<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$song_id = $_POST['song_id'];
$film_id = $_POST['film_id'];

$sql = "INSERT INTO filmsoundtrack (song_id, film_id) VALUES ($song_id, $film_id)";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>