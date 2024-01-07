<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SESSION["user"]["role"] == 0) {
    header("Location: index.php");
    exit();
}
?>