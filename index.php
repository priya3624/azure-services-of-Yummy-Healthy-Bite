<!DOCTYPE html>
<html>

<head>
  <title>Yummy Healthy Bite</title>
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

    .search-container {
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: center;
    }

    .search-input {
        width: 500px;
        padding: 20px;
        border-radius: 30px;
        border: 1px solid;
        font-size: 16px;
        background-color: #451313;
        margin-top: 20px;
    }

    /* .search-button {
        padding: 10px 20px;
        border-radius: 5px;
        border: none;
        background-color: #007BFF;
        color: white;
        cursor: pointer;
        margin-left: 10px;
        font-size: 16px;
    }

    .search-button:hover {
        background-color: #0056b3; */
    /* } */

    .search-results {
        width: 60%;
        margin: 20px auto;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid;
        /* background-color: white; */
    }

    .search-results p {
        margin: 0;
        padding: 5px 0;
        border-bottom: 1px solid;
    }

    .search-results p:last-child {
        border-bottom: none;
    }

  </style>
</head>

<body>
  <?php
  include 'includes/header.php';

  ?>

  <div class="main-content">

    <div class="page-header">
      <h1>Welcome to Yummy Healthy Bite</h1>
      <p>Discover delicious recipes from around the world</p>

      <!-- <div class="search">
        <div class="fa fa-search"></div>
        <input type="text" name="" id="search" placeholder="What do you want to eat?" onkeyup="search()">
        <div class="fa fa-times" onclick="clearInput()"></div>
      </div> -->

      <div class="search-container">
        <form action="search_results.php" method="GET">
          
          <input class="search-input" type="text" name="search_query" placeholder="What do you want to eat?" onkeyup="search()">
          <!-- <input class="search-button" type="submit" value="Search"> -->
        </form>
      </div>

    </div>

    <?php
    // Connect to your database (replace with your actual credentials)
    $connection = new mysqli('localhost', 'root', '', 'food_recipe_db');

    // Get the search query from the URL parameter
    $search_query = isset($_GET['search_query']) ? $_GET['search_query'] : '';

    // Sanitize the input (prevent SQL injection)
    $safe_query = $connection->real_escape_string($search_query);

    // Execute the SQL query
    $sql = "SELECT * FROM recipes WHERE title LIKE '%$safe_query%'";
    $result = $connection->query($sql);  

    // Display search results
    while ($row = $result->fetch_assoc()) {
      // echo $row['title']; // Replace with the actual column name you want to display
    }

    // Close the database connection
    $connection->close();
    ?>






    <div class="main-container">
      <div class="row">
        <?php
        // Include the database configuration file
        include 'includes/config.php';

        // Retrieve recipes from the database
        $sql = "SELECT * FROM recipes";
        $result = $conn->query($sql);

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
        $conn->close();
        ?>
      </div>
    </div>

  </div>
  <!-- MAIN CONTENT -->

  <?php
  include 'includes/footer.php';
  ?>
 
</body>

</html>