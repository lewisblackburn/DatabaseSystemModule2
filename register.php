<?php
$pageTitle = "Register";
session_start();
if (isset($_SESSION["user"])) {
  header("Location: index.php");
  exit();
}
?>

<html lang="en">

<head>
  <?php include 'utils/head.php'; ?>
</head>

<body>
  <div class="grid row align-items-center" style="height:100%;margin-right:40px;">
    <div class='col bg' style="margin-right:40px;"></div>
    <div class="container col-lg-5">
      <h1 class="fw-semibold">Register</h1>
      <p>Enter the details to register.</p>
      <?php
      if (isset($_POST["submit"])) {
        $fullName = $_POST["fullname"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $repeatPassword = $_POST["repeat_password"];
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $errors = array();

        if (empty($fullName) or empty($email) or empty($password) or empty($repeatPassword))
          array_push($errors, "All fields are required");

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
          array_push($errors, "Email is not valid");

        if (strlen($password) < 8)
          array_push($errors, "Password must be at least 8 characters long");

        if ($password !== $repeatPassword)
          array_push($errors, "Password does not match");

        require_once "utils/database.php";
        $sql = "SELECT id, full_name, email, password, role FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $rowCount = mysqli_num_rows($result);
        if ($rowCount > 0)
          array_push($errors, "Email already exists!");

        if (count($errors) > 0) {
          foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
          }
        } else {
          $sql = "INSERT INTO user (full_name, email, password) VALUES (?, ?, ?)";
          $stmt = mysqli_stmt_init($conn);
          $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

          if ($prepareStmt) {
            mysqli_stmt_bind_param($stmt, "sss", $fullName, $email, $passwordHash);
            mysqli_stmt_execute($stmt);
            $sql = "SELECT id, email FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

            try {
              $sql = "INSERT INTO list (name, user_id) VALUES ('Watchlist', " . $user['id'] . ")";
              $result = mysqli_query($conn, $sql);
            } catch (Exception $e) {
            }

            // remove password before setting session
            unset($user["password"]);
            session_start();
            $_SESSION["user"] = $user;
            header("Location: index.php");
            die();
          } else {
            die("Something went wrong");
          }
        }

      }
      ?>
      <form action="register.php" method="post">
        <div class="form-group">
          <input type="text" class="form-control" name="fullname" placeholder="Full Name">
        </div>
        <div class="form-group">
          <input type="email" class="form-control" name="email" placeholder="Email">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password" placeholder="Password">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password">
        </div>
        <div class="form-btn">
          <button type="submit" class="btn btn-primary" name="submit">Sign Up</button>
        </div>
      </form>
      <div style="font-size:15px;">
        <p class="text-body-tertiary">Already registered? <a href="login.php">Sign In</a></p>
      </div>
    </div>
</body>

</html>