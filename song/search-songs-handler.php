<?php
require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'];

    $searchSql = "SELECT id, name FROM song WHERE name LIKE '%$searchTerm%'";
    $searchResult = mysqli_query($conn, $searchSql);

    $results = array();
    while ($row = mysqli_fetch_assoc($searchResult)) {
        $results[] = array(
            'song_id' => $row['id'],
            'song_name' => $row['name'],
        );
    }

    echo json_encode($results);
} else {
    echo "Invalid request";
}
?>