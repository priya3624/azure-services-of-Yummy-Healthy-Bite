<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'includes/config.php';

    // Get form data
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];
    $emailInput = $_POST['email'];

    // Insert the new user into the database
    $sql = "INSERT INTO Users (username, password, email)
            VALUES ('$usernameInput', '$passwordInput', '$emailInput')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration successful!');</script>";
        header('Refresh: .5; URL = login.php');
        exit;
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $conn->error . "');</script>";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Signup Page</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: sans-serif;

        background-image: url('images/background.jpg');
        background-repeat: no-repeat;
        background-size: cover; /* This will make the image cover the entire page */
      }

      .page-header {
        padding: 1px;
      }

      button {
        margin: 0 auto;
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
            <h2>Signup</h2>
            <form method="post">
                <div class="user-box">
                    <input type="text" name="username" required="">
                    <label>Username</label>
                </div>
                <div class="user-box">
                    <input type="password" name="password" required="">
                    <label>Password</label>
                </div>
                <div class="user-box">
                    <input type="email" name="email"  pattern="[a-z0-9._%+\-]+@[a-z0-9.\-]+\.[a-z]{2,}$" required="">
                    <label>Email</label>
                </div>
                <button type="submit" name="">
                    <span class="transition"></span>
                    <span class="gradient"></span>
                    <span class="label">SIGNUP</span>
                </button>
            </form>
        </div>
    </div>
    <!-- MAIN CONTAINER -->
    <?php
      include 'includes/footer.php';
    ?>
</body>
</html>
