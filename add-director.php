<?php
$pageTitle = "Add Director";
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
        $errors = array();

        if (empty($name))
            array_push($errors, "Name is required");

        require_once "utils/database.php";

        if (count($errors) > 0) {
            foreach ($errors as $error) {
                echo "<div class='alert alert-danger'>$error</div>";
            }
        } else {
            $sql = "INSERT INTO director (name) VALUES (?)";
            $stmt = mysqli_stmt_init($conn);
            $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

            if ($prepareStmt) {
                mysqli_stmt_bind_param($stmt, "s", $name);
                $result = mysqli_stmt_execute($stmt);
                if ($result) {
                    $id = mysqli_insert_id($conn);
                    header("Location: index.php");
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
    <form action="add-director.php" method="post" class='mt-5 wrapper'>
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name">
        </div>
        <div class="form-btn">
            <input type="submit" class="btn btn-primary" value="Add" name="submit">
        </div>
    </form>
</body>

</html>