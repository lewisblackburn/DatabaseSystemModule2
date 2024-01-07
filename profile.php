<?php
require_once("utils/requires-user.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    $id = $_SESSION["user"]["id"];
}

require_once "utils/database.php";
$sql = "SELECT id, full_name, email FROM user WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

$pageTitle = $user["full_name"] . "'s Profile";

if ($id == $_SESSION["user"]["id"]) {
    $edit = "<a href='edit-profile.php' class='btn btn-primary'>Edit Profile</a>";
} else {
    $edit = "";
}
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
                <h1 class="mt-5">
                    <?= $user["full_name"] ?>
                </h1>
                <p>
                    <?= $user["email"] ?>
                </p>
                <?= $edit ?>

                <div class='mt-5'></div>
                <div class='d-flex justify-content-between align-items-center'>
                    <h2>Lists</h2>
                    <?php
                    if ($id == $_SESSION["user"]["id"]) {
                        ?>
                        <form action="list/create-list.php" method="POST" class='d-flex gap-2 align-items-center'>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </form>
                        <?php
                    }
                    ?>
                </div>
                <div class="d-flex flex-column gap-3">
                    <?php
                    $sql = "SELECT id, name FROM list WHERE user_id = $id";
                    $result = mysqli_query($conn, $sql);
                    $lists = mysqli_fetch_all($result, MYSQLI_ASSOC);

                    foreach ($lists as $list) {
                        ?>
                        <div class="col">
                            <a href="list.php?id=<?= $list['id'] ?>">
                                <div>
                                    <h3>
                                        <?= $list['name'] ?>
                                    </h3>
                                </div>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>