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
            <h1>Films</h1>
            <form action="films.php" method="get">
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
            $sql = "SELECT id, title, image FROM film WHERE verified = 1";
            if (isset($_GET['search'])) {
                $search = $_GET['search'];
                $sql .= " AND (title LIKE '%$search%' OR description LIKE '%$search%')";
            }
            if (isset($_GET['order'])) {
                $order = $_GET['order'];
                $sql .= " ORDER BY title $order";
            }
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
</body>

</html>