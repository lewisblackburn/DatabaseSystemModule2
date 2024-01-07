<?php
require_once "../utils/requires-user.php";
require_once "../utils/database.php";
$list_id = $_POST['list_id'];
$film_id = $_POST['film_id'];

try {
    $sql = "SELECT id FROM list WHERE id = $list_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 0) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        return;
    }
    $sql = "INSERT INTO listfilm (list_id, film_id) VALUES ($list_id, $film_id)";
    $result = mysqli_query($conn, $sql);
    header("Location: ../list.php?id=$list_id");
} catch (Exception $e) {
    header("Location: ../list.php?id=$list_id");
}

?>