<?php
$pageTitle = "Dashboard";
require_once('utils/requires-admin.php');
require_once "utils/database.php";
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <div class='wrapper'>
        <?php
        $sql = "SELECT COUNT(*) AS count FROM film WHERE verified = 0";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_fetch_assoc($result)['count'];
        if ($count > 0) {
            ?>
            <h2 class="fw-semibold mb-4">Unverified Films</h2>
            <?php
        }
        ?>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT id, title, image, verified FROM film WHERE verified = 0";
            $result = mysqli_query($conn, $sql);
            $films = mysqli_fetch_all($result, MYSQLI_ASSOC);

            foreach ($films as $film) {
                ?>
                <div class="col item">
                    <a href="film.php?id=<?= $film['id'] ?>">
                        <?php include 'components/film-poster.php'; ?>
                        <?php include 'film/verify-film-button.php'; ?>
                    </a>
                </div>
                <?php
            }
            ?>
        </div>

        <div class='mt-5'>
            <?php
            $sql = "SELECT COUNT(*) AS count FROM song WHERE verified = 0";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_fetch_assoc($result)['count'];
            if ($count > 0) {
                ?>
                <h2 class="fw-semibold mb-4">Unverified Songs</h2>
                <?php
            }
            ?>

            <div class="d-flex flex-column gap-3">
                <?php
                $sql = "SELECT id, image, name, description, verified FROM song WHERE verified = 0";
                $result = mysqli_query($conn, $sql);
                $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($songs as $song) {
                    ?>
                    <div class="col">
                        <a href="song.php?id=<?= $song['id'] ?>" class=" d-flex align-items-center gap-2"
                            style="width:100%;">
                            <div class="mt-3">
                                <?php include 'song/verify-song-button.php'; ?>
                            </div>
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
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>