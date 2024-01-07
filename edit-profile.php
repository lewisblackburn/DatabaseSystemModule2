<?php
require_once("utils/requires-user.php");
require_once "utils/database.php";
$id = $_SESSION["user"]["id"];
$sql = "SELECT id, full_name, email FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'utils/head.php'; ?>
</head>

<body>
    <?php include "components/navbar.php" ?>
    <div class="wrapper">
        <div class="row">
            <div class="col">
                <form action="update-profile.php" method="post">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                            value="<?= $user["full_name"] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= $user["email"] ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
</body>

</html>