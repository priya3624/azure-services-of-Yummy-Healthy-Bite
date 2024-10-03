<!DOCTYPE html>
<html>

<head>
  <title>Search Results</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="shortcut icon" href="./images/Logo.jpeg" type="image/x-icon">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    body {
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
    }

    
  </style>
</head>

<body>

  <?php
  include 'includes/header.php';
  echo '<h2> Your Search Result:</h2>';

  // Get the search query from the URL parameter
  $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

  if ($search_query != '') {
    // Connect to your database (replace with your actual credentials)
    $connection = new mysqli('localhost', 'root', '', 'food_recipe_db');

    // Sanitize the input (prevent SQL injection)
    $safe_query = $connection->real_escape_string($search_query);

    // Execute the SQL query
    $sql = "SELECT * FROM recipes WHERE title LIKE '%$safe_query%'";
    $result = $connection->query($sql);  

    // Display search results
    if ($result->num_rows > 0) {
      // Output data of each row
      $counter = 0;
      while ($row = $result->fetch_assoc()) {
        if ($counter % 3 == 0) { // Change from 2 to 3
          echo '<div class="recipe-row">';
        }
        echo '<a href="recipe.php?id=' . $row['recipe_id'] . '" class="recipe-card">';
        echo '<h2>' . $row['title'] . '</h2>';
        echo '<img src="images/' . $row['image_url'] . '" alt="' . $row['title'] . '">';
        echo '<p>' . $row['description'] . '</p>';
        echo '</a>';
        if ($counter % 3 == 2 || $counter == $result->num_rows - 1) { // Change from 1 to 2
          echo '</div>';
        }
        $counter++;
      }
    } else {
      echo "No recipes found.";
    }

    // Close the database connection
    $connection->close();
  } else {
    echo "Please enter a search query.";
  }

  include 'includes/footer.php';
  ?>
  
</body>

</html>
