<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$song_id = $_POST['song_id'];
$film_id = $_POST['film_id'];

$sql = "DELETE FROM filmsoundtrack WHERE song_id = $song_id AND film_id = $film_id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: " . $_SERVER['HTTP_REFERER']);
} else {
    echo "Error: " . mysqli_error($conn);
}
?>