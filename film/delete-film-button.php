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

<form action="film/delete-film.php" method="post">
    <input type="hidden" name="id" value="<?= $film['id'] ?>">

    <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash"></i>
    </button>
</form>