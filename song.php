<?php
session_start();
require_once "utils/database.php";
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$sql = "SELECT id, name, description, artist, image, verified FROM song WHERE id = $id";

$result = mysqli_query($conn, $sql);
$song = mysqli_fetch_assoc($result);
if (!$song) {
    header("Location: index.php");
}

$pageTitle = $song['name'] . " | Song";
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <div class="wrapper">

        <div class="d-flex align-items-center gap-2" style="width:100%;">
            <?php include 'components/song-poster.php'; ?>
            <div class="d-flex flex-column">
                <b>
                    <?= $song['name'] ?> -
                    <?= $song['artist'] ?>
                </b>
                <span>
                    <?= $song['description'] ?>
                    <span>
            </div>
        </div>
        <div class='d-flex gap-2 my-3'>
            <?php
            if (isset($_SESSION['user'])) {
                ?>
                <div>
                    <a href="edit-song.php?id=<?= $id ?>" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i>
                    </a>
                </div>
                <?php
            }
            ?>
            <?php include 'song/verify-song-button.php'; ?>
            <?php include 'song/delete-song-button.php'; ?>
        </div>

        <h2>Appears on</h2>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-1">
            <?php
            $sql = "SELECT film.id, film.title, film.image 
            FROM filmsoundtrack
            JOIN film ON filmsoundtrack.film_id = film.id
            WHERE filmsoundtrack.song_id = $id";

            $result = mysqli_query($conn, $sql);
            $soundtrack = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($soundtrack as $film) {
                ?>
                <div class="col item">
                    <a href="film.php?id=<?= $film['id'] ?>">
                        <?php include 'components/film-poster.php'; ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>

</body>

</html>