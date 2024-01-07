<?php
require_once('utils/requires-user.php');
$id = $_GET['id'];
require_once('utils/database.php');
$sql = "SELECT id, name, description, artist, image FROM song WHERE id = $id";
$result = mysqli_query($conn, $sql);
$song = mysqli_fetch_assoc($result);
$pageTitle = "Edit - " . $song['name'];

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $artist = $_POST['artist'];
    $imageURL = $_POST['image'];
    $errors = array();

    if (empty($name))
        array_push($errors, "Name is required");

    if (empty($description))
        array_push($errors, "Description is required");

    if (empty($artist))
        array_push($errors, "Artist is required");

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql = "UPDATE song SET name = ?, description = ?, artist = ?, image = ? WHERE id = $id";
        $stmt = mysqli_stmt_init($conn);
        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $name, $description, $artist, $imageURL);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
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

<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include 'components/navbar.php'; ?>

    <form action="edit-song.php?id=<?= $id ?>" method="post" class='wrapper'>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="name" value="<?= $song['name'] ?>">
        </div>
        <div class="form-group">
            <textarea class="form-control" name="description" placeholder="Description"><?= $song['description'] ?>
</textarea>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="artist" placeholder="Artist" value="<?= $song['artist'] ?>">
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="image" placeholder="Image URL" value="<?= $song['image'] ?>">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Update" name="submit">
        </div>
    </form>
</body>

</html>