<?php
require_once "utils/requires-user.php";
require_once "utils/database.php";
$list_id = $_GET['id'];
$sql = "SELECT film_id FROM listfilm WHERE list_id = $list_id";
$result = mysqli_query($conn, $sql);
?>
<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include "components/navbar.php" ?>
    <div class='d-flex flex-column wrapper'>
        <div>
            <div class='d-flex align-items-center justify-content-between mb-5'>
                <h1>
                    <?php
                    $sql = "SELECT id, name FROM list WHERE id = $list_id";
                    $result = mysqli_query($conn, $sql);
                    $list = mysqli_fetch_assoc($result);
                    echo $list['name'];
                    ?>
                </h1>
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <form action="list/delete-list.php" method="post">
                        <input type="hidden" name="list_id" value="<?= $list_id ?>">
                        <input type="submit" class="btn btn-danger" value="Delete List">
                    </form>
                    <?php
                }
                ?>
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                $sql = "SELECT film.id, film.title, film.image
                FROM listfilm
                JOIN film ON listfilm.film_id = film.id
                WHERE listfilm.list_id = $list_id";

                $result = mysqli_query($conn, $sql);
                $films = mysqli_fetch_all($result, MYSQLI_ASSOC);

                foreach ($films as $film) {
                    ?>
                    <div class="col item position-relative">
                        <a href="film.php?id=<?= $film['id'] ?>">
                            <?php include 'components/film-poster.php'; ?>
                            <?php
                            if (isset($_SESSION['user'])) {
                                ?>
                                <form action="list/remove-film-from-list.php" method="post" class="position-absolute"
                                    style="right:50px;top:10px;">
                                    <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
                                    <input type="hidden" name="list_id" value="<?= $list_id ?>">
                                    <button type="submit" class="btn btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php
                            }
                            ?>
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