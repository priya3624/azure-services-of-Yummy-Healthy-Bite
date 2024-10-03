<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'includes/config.php';

    // Get form dataa
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];

    // Query the database
    $sql = "SELECT * FROM Users WHERE username='$usernameInput' AND password='$passwordInput'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Login successful
        session_start();
        $_SESSION['username'] = $usernameInput;
        echo "<script>alert('Login successful!');</script>";
        header('Refresh: .5; URL = index.php');
        exit;
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid username or password.');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
      body {
        margin: 0;
        padding: 0;

        background-image: url('images/background.jpg');
        background-repeat: no-repeat;
        background-size: cover; /* This will make the image cover the entire page */
      }

      .page-header {
        padding: 1px;
      }
    </style>
</head>
<body>
    <?php
      include 'includes/header.php';
    ?>

      <header class="page-header1"></header>

    <div class="main-container">
      <div class="login-box">
          <h2>Login</h2>
          <form method="post">
              <div class="user-box">
                  <input type="text" name="username" required="">
                  <label>Username</label>
              </div>
              <div class="user-box">
                  <input type="password" name="password" required="">
                  <label>Password</label>
              </div>
              <div class="button-container">
                  <button type="submit" name="" class="login-button">
                    <span class="transition"></span>
                    <span class="gradient"></span>
                    <span class="label">LOGIN</span>
                  </button>
                  <button onclick="location.href='signup.php'" class="signup-button">
                      <span class="transition"></span>
                      <span class="gradient"></span>
                      <span class="label">SIGNUP</span>
                  </button>
              </div>
          </form>
      </div>
    </div>
    <!-- MAIN CONTAINER -->
    <?php
      include 'includes/footer.php';
    ?>
</body>
</html>
