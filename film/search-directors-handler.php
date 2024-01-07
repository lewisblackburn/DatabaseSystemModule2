<?php
require_once "../utils/database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = $_POST['searchTerm'];

    $searchSql = "SELECT id, name FROM director WHERE name LIKE '%$searchTerm%'";
    $searchResult = mysqli_query($conn, $searchSql);

    $results = array();
    while ($row = mysqli_fetch_assoc($searchResult)) {
        $results[] = array(
            'id' => $row['id'],
            'name' => $row['name'],
        );
    }

    echo json_encode($results);
} else {
    echo "Invalid request";
}
?>