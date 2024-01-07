<?php
session_start();
require_once "utils/database.php";
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include "components/navbar.php" ?>
    <div class='d-flex flex-column wrapper'>
        <div>
            <h1>Films: Recently Added</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $sql = "SELECT id, title, image FROM film WHERE verified = 1 ORDER BY id DESC LIMIT 10";
                $result = mysqli_query($conn, $sql);
                $films = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($films as $film) {
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
        </div>
        <div class='mb-5'></div>
        <div>
            <h1>Songs: Recently Added</h1>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $sql = "SELECT id, name, description, image FROM song WHERE verified = 1 ORDER BY id DESC LIMIT 10";
                $result = mysqli_query($conn, $sql);
                $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($songs as $song) {
                    ?>
                    <a href="song.php?id=<?= $song['id'] ?>" class=" d-flex align-items-center gap-2" style="width:100%;">
                        <?php include 'components/song-poster.php'; ?>
                        <div class="d-flex flex-column">
                            <b>
                                <?= $song['name'] ?>
                            </b>
                            <span>
                                <?= $song['description'] ?>
                                <span>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>