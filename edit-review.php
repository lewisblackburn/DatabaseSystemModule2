<?php
require_once "utils/requires-user.php";
require_once "utils/database.php";
$film_id = $_GET['film_id'];
$user_id = $_SESSION['user']['id'];
$sql = "SELECT film_id, user_id, rating, comment FROM review WHERE film_id = $film_id AND user_id = $user_id";
$result = mysqli_query($conn, $sql);
$review = mysqli_fetch_assoc($result);

if (!$review) {
    header("Location: film.php?id=$film_id");
    die();
}


if (isset($_POST['submit'])) {
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $errors = array();

    if (empty($rating))
        array_push($errors, "Rating is required");

    if (empty($comment))
        array_push($errors, "Comment is required");

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "UPDATE review SET rating = ?, comment = ? WHERE film_id = $film_id AND user_id = $user_id";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ss", $rating, $comment);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                header("Location: film.php?id=$film_id");
                die();
            } else {
                die("Something went wrong");
            }
        } else {
            die("Something went wrong");
        }
    }
}
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>

    <form action="edit-review.php?film_id=<?= $film_id ?>" method="post" class='wrapper'>
        <div class="form-group">
            <input type="number" name="rating" id="rating" min="0" max="10" class="form-control"
                placeholder="Rating 0-10" style="width:135px;" value="<?= $review['rating'] ?>">
        </div>
        <div class="form-group">
            <textarea name="comment" id="comment" cols="50" rows="1" class="form-control"
                placeholder="Write a review"><?= $review['comment'] ?></textarea>
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Update" name="submit">
        </div>
    </form>
    <form action="review/delete-review.php" method="post" class="d-flex justify-content-center">
        <input type="hidden" name="film_id" value="<?= $film_id ?>">
        <input type="hidden" name="user_id" value="<?= $user_id ?>">
        <input type="submit" class="btn btn-danger" value="Delete Review">
    </form>
</body>

</html>