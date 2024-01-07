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
        <div class='d-flex align-items-center justify-content-between'>
            <h1>Songs</h1>
            <form action="songs.php" method="get">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search" name="search">
                    <select class="form-select" name="order">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                </div>
            </form>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT id, name, description, image FROM song WHERE verified = 1";
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql .= " AND (name LIKE '%$search%' OR description LIKE '%$search%')";
            }
            if (isset($_GET['order'])) {
                $order = $_GET['order'];
                $sql .= " ORDER BY name $order";
            }
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
</body>

</html>