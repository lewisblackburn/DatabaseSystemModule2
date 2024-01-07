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

<form action="song/delete-song.php" method="post">
    <input type="hidden" name="id" value="<?= $song['id'] ?>">
    <button type="submit" class="btn btn-danger">
        <i class="bi bi-trash"></i>
    </button>
</form>