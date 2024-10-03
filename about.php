<!DOCTYPE html>
<html>
<head>
    <title>About Us</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    <style>
      body {
        margin: 0;
      }

    .page-header {
      padding: 3px;
    }
    </style>
</head>
<body>
  <?php
    include 'includes/header.php';
    include 'includes/config.php';
  ?>

  <header class="page-header1">
    <h1>About US</h1>
  </header>
  <div class="about-container main-container">
    


    <?php
    // Retrieve the content from the about_page table
    $query = "SELECT * FROM about_page";
    $result = mysqli_query($conn, $query);

    // Loop through the retrieved data and display it
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $content = $row['content'];

        echo "<h2>$title</h2>";
        echo $content;
    }
    ?>

  </div>

  <?php
    include 'includes/footer.php';
  ?>
</body>
</html>
