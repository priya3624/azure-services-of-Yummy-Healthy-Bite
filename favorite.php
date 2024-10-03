<!DOCTYPE html>
<html>
<head>
  <title>User Favorites - Recipe Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    body {
      margin: 0;
    }

    a {
      text-decoration: none;
    }

    .main-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around; /* This will add space around the items */
      padding: 20px; /* This will add padding to the container */
    }

    .recipe-card {
        flex-basis: calc(33.33% - 40px); /* This will make the item take up one third of the container width, subtracting for padding/margin */
        box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); /* This will add a shadow to the item */
        margin: 20px; /* This will add margin to the item */
        padding: 20px; /* This will add padding to the item */
    }

    .page-header {
      padding: 3px;
    }
  </style>
</head>
<body>
  <?php
    include 'includes/header.php';
    
    // Check if user is logged in
    if (!isset($_SESSION['username'])) {
        echo "You must be logged in to view this page.";
        exit;
    }

    include 'includes/config.php';
    $username = $_SESSION['username'];

    // Retrieve the user ID from the username
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
    $stmt->close();

    // Retrieve favorite recipes from the database
    $sql = "SELECT Recipes.recipe_id, Recipes.title, Recipes.image_url FROM Recipes 
            INNER JOIN Favorites ON Recipes.recipe_id = Favorites.recipe_id 
            WHERE Favorites.user_id = $user_id";
    $result = $conn->query($sql);

    echo '<header class="page-header1"><h1>Favorite Recipes</h1></header>';

    // Display favorite recipes
    echo '<div class="main-container">';
    while ($row = $result->fetch_assoc()) {
        echo '<div class="recipe-card"><a href="recipe.php?id=' . $row['recipe_id'] . '">';
        echo '<h2>' . $row['title'] . '</h2>';
        echo '<img src="images/' . $row['image_url'] . '" alt="' . $row['title'] . '"></a>';
        echo '</div>';
    }
    echo '</div>';

    $conn->close();
  ?>

  <?php
    include 'includes/footer.php';
  ?>
</body>
</html>
