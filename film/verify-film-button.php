<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION["user"])) {
    return;
}
if ($_SESSION["user"]["role"] == 0) {
    return;
}
?>

<form action="film/verify-film.php" method="post">
    <input type="hidden" name="id" value="<?= $film['id'] ?>">
    <?php
    if ($film["verified"] == 1) {
        ?>
        <button type="submit" class="btn btn-danger">
            <i class="bi bi-x"></i>
        </button>
        <?php
    } else {
        ?>
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check"></i>
        </button>
        <?php
    }
    ?>
</form>