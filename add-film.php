<?php
$pageTitle = "Add Film";
require_once('utils/requires-user.php');
?>

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>
    <?php
    if (isset($_POST["submit"])) {
        $title = $_POST["title"];
        $description = $_POST["description"];
        $releaseDate = $_POST["release_date"];
        $imageURL = $_POST["image"];
        $errors = array();

        if (empty($title))
            array_push($errors, "Title is required");

        if (empty($description))
            array_push($errors, "Description is required");

        if (empty($releaseDate))
            array_push($errors, "Release Date is required");

        require_once "utils/database.php";

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO film (title, description, release_date, image) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $title, $description, $releaseDate, $imageURL);
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    $id = mysqli_insert_id($conn);
                    header("Location: film.php?id=$id");
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
    <form action="add-film.php" method="post" class='mt-5 wrapper'>
        <div class="form-group">
            <input type="text" class="form-control" name="title" placeholder="Title">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="description" placeholder="Description"></textarea>
        </div>
        <div class="form-group">
            <input type="date" class="form-control" name="release_date" placeholder="Release Date">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="image" placeholder="Poster Image URL">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Add" name="submit">
        </div>
    </form>
</body>

</html>