<?php
session_start();
require_once "utils/database.php";
$id = isset($_GET['id']) ? $_GET['id'] : '1';
$sql = "SELECT id, title, description, release_date, image, director_id, verified FROM film WHERE id = $id";
$result = mysqli_query($conn, $sql);
$film = mysqli_fetch_assoc($result);
if (!$film) {
    header("Location: index.php");
}
$year = "(" . substr($film['release_date'], 0, 4) . ")";
$pageTitle = $film['title'] . " | Film";
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <div class='wrapper'>
        <div class='d-flex gap-3'>
            <div class="d-flex flex-column gap-3 position-relative" style="width:150px;">
                <?php include 'components/film-poster.php'; ?>
                <div class="d-flex align-items-center justify-content-between position-absolute"
                    style="top:10px;padding-left:10px;padding-right:10px;width:150px;">
                    <?php include 'film/verify-film-button.php'; ?>
                    <?php include 'film/delete-film-button.php'; ?>
                </div>
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <a href="edit-film.php?id=<?= $id ?>" class="btn btn-primary">Edit Film</a>
                    <?php
                }
                ?>
                <?php
                if (isset($_SESSION['user'])) {
                    ?>
                    <form action="list/add-film-to-list.php" method="post">
                        <input type="hidden" name="film_id" value="<?= $id ?>">
                        <select name="list_id" id="list_id" style="width:100%;margin-bottom:10px;">
                            <?php
                            $sql = "SELECT id, name FROM list WHERE user_id = " . $_SESSION['user']['id'];
                            $result = mysqli_query($conn, $sql);
                            $lists = mysqli_fetch_all($result, MYSQLI_ASSOC);

                            if (count($lists) == 0) {
                                ?>
                                <option value="0">No lists found</option>
                                <?php
                            }


                            foreach ($lists as $list) {
                                ?>
                                <option value="<?= $list['id'] ?>">
                                    <?= $list['name'] ?>
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                        <input type="submit" class="btn btn-primary" value="Add to List" style="width:100%;">
                    </form>
                    <?php
                }
                ?>
            </div>
            <div>
                <h1 class="fw-semibold">
                    <?= $film['title'] ?>
                    <span class="text-body-secondary">
                        <?= $year ?>
                </h1>
                <p class="text-body-secondary" style="width:50%;">
                    <?= $film['description'] ?>
                </p>
            </div>
        </div>

        <div class='d-flex align-items-center justify-content-between mt-5'>
            <h1>Director</h1>
        </div>

        <?php
        if ($film['director_id'] != null) {
            $sql = "SELECT id, name FROM director WHERE id = $film[director_id]";
            $result = mysqli_query($conn, $sql);
            $director = mysqli_fetch_all($result, MYSQLI_ASSOC);
            if (count($director) > 0) {
                ?>
                <div class="d-flex align-items-center gap-2" style="width:100%;">
                    <b>
                        <?= $director[0]['name'] ?>
                    </b>
                </div>
                <?php
            }
        }
        ?>

        <div class='d-flex align-items-center justify-content-between mt-5'>
            <h1>Soundtrack</h1>
        </div>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            <?php
            $sql = "SELECT song.id, song.name, song.image
            FROM filmsoundtrack
            JOIN song ON filmsoundtrack.song_id = song.id
            WHERE filmsoundtrack.film_id = $id";

            $result = mysqli_query($conn, $sql);
            $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
            ?>
            <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                <?php
                foreach ($songs as $song) {
                    ?>
                    <a href="song.php?id=<?= $song['id'] ?>" class="d-flex align-items-center gap-2" style="width:100%;">
                        <?php include 'components/song-poster.php'; ?>
                        <div class="d-flex align-items-center">
                            <b>
                                <?= $song['name'] ?>
                            </b>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class='d-flex align-items-center justify-content-between mt-5'>
            <h1>Reviews</h1>
            <?php
            if (isset($_SESSION['user'])) {
                ?>
                <form action="review/add-review.php" method="post" class="d-flex gap-2">
                    <input type="hidden" name="film_id" value="<?= $id ?>">
                    <input type="hidden" name="user_id" value="<?= $_SESSION['user']['id'] ?>">
                    <input type="number" name="rating" id="rating" min="0" max="10" class="form-control"
                        placeholder="Rating 0-10" style="width:135px;">
                    <textarea name="comment" id="comment" cols="50" rows="1" class="form-control"
                        placeholder="Write a review"></textarea>
                    <input type="submit" class="btn btn-primary" value="Add Review">
                </form>
                <?php
            }
            ?>
        </div>

        <?php
        $sql = "SELECT review.user_id, review.rating, review.comment, user.full_name, film.title
        FROM review
        JOIN user ON review.user_id = user.id
        JOIN film ON review.film_id = film.id
        WHERE review.film_id = $id";

        $result = mysqli_query($conn, $sql);
        $reviews = mysqli_fetch_all($result, MYSQLI_ASSOC);
        ?>
        <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
            <?php
            foreach ($reviews as $review) {
                ?>
                <div class="col" style="width:100%;">
                    <a href="edit-review.php?film_id=<?= $id ?>" class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center gap-2">
                                <div class="d-flex flex-column">
                                    <span>
                                        <b>
                                            <?= $review['full_name'] ?>
                                        </b> rated <b>
                                            <?= $review['title'] ?>
                                        </b>
                                        <?= $review['rating'] ?> stars
                                    </span>
                                    <span>
                                        <?= $review['comment'] ?>
                                    </span>
                                </div>
                            </div>
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