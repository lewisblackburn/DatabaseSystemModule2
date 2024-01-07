<?php
$pageTitle = "Add Song";
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
        $name = $_POST["name"];
        $description = $_POST["description"];
        $artist = $_POST["artist"];
        $imageURL = $_POST["image"];
        $errors = array();

        if (empty($name))
            array_push($errors, "Name is required");

        if (empty($description))
            array_push($errors, "Description is required");

        if (empty($artist))
            array_push($errors, "Artist is required");

        require_once "utils/database.php";

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO song (name, description, artist, image) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "ssss", $name, $description, $artist, $imageURL);
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    $id = mysqli_insert_id($conn);
                    header("Location: song.php?id=$id");
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
    <form action="add-song.php" method="post" class='mt-5 wrapper'>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="description" placeholder="Description"></textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="artist" placeholder="Artist">
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