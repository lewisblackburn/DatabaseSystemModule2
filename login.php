<?php
$pageTitle = "Login";
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
      <h1 class="fw-semibold">Login</h1>
      <p>Enter your email and password to login.</p>
      <?php
      if (isset($_POST["submit"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        require_once "utils/database.php";
        $sql = "SELECT id, full_name, email, password, role FROM user WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_array($result, MYSQLI_ASSOC);

        if ($user) {
          if (password_verify($password, $user["password"])) {
            session_start();
            // remove password before setting session
            unset($user["password"]);
            $_SESSION["user"] = $user;
            header("Location: index.php");
            die();
          } else {
            echo "<div class='alert alert-danger'>Password does not match</div>";
          }
        } else {
          echo "<div class='alert alert-danger'>Email does not match</div>";
        }
      }
      ?>
      <form action="login.php" method="post">
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" autocomplete="off">
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
        </div>
        <div class="form-btn">
          <button type="submit" class="btn btn-primary" name="submit">Sign In</button>
        </div>
      </form>
      <div style="font-size:15px;">
        <p class="text-body-tertiary">Don't have an account? <a href="register.php">Sign Up</a></p>
      </div>
    </div>
  </div>
</body>

</html>