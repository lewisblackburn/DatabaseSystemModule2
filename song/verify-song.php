<?php
session_start();
if (isset($_SESSION["user"])) {
    if ($_SESSION["user"]["role"] == 1) {
        require_once "../utils/database.php";
        $id = $_POST["id"];
        $sql = "SELECT id, verified FROM song WHERE id = $id";
        $result = mysqli_query($conn, $sql);
        $song = mysqli_fetch_assoc($result);
        if ($song["verified"] == 1) {
            $sql = "UPDATE song SET verified = 0 WHERE id = $id";
        } else {
            $sql = "UPDATE song SET verified = 1 WHERE id = $id";
        }
        $result = mysqli_query($conn, $sql);
        header("Location: " . $_SERVER['HTTP_REFERER']);
    } else {
        header("Location: index.php");
    }
} else {
    header("Location: index.php");
}
?>