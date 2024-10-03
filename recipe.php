<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Yummy Healthy Bite - Recipe Details</title>
  <link rel="stylesheet" type="text/css" href="style.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Kalam:wght@400;700&display=swap">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
  <style>
    body {
      background-color: #f2f2f2;
      margin: 0;
      padding: 0;
      height: 100vh; /* Full height of the viewport */
      display: flex; /* Use flexbox to manage layout */
      flex-direction: column; /* Arrange items in a column */
    }

    .main-content {
      display: flex; /* Use flexbox for layout */
      flex: 1; /* Make main content stretch to fill remaining space */
      padding: 20px; /* Add padding around the main content */
    }

    .main-container, .translation-container {
      flex: 1; /* Allow both sections to grow equally */
      padding: 20px; /* Add padding */
      background-color: white; /* Background for visibility */
      border-radius: 8px; /* Round corners */
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add shadow */
      margin: 0 10px; /* Add margin between the two sections */
    }

    .recipe-card-details {
      text-align: left; /* Align text to the left */
    }

    .translation-select, .translation-button {
      margin-top: 10px; /* Add margin to the select and button */
    }

    h1 {
      text-align: center; /* Center the main title */
      margin: 20px 0; /* Add some margin for spacing */
    }

    /* New styles for translated text */
    .translated-recipe {
      margin-top: 20px; /* Add space above the translated text */
      background-color: #e0f7fa; /* Light blue background for visibility */
      padding: 15px; /* Padding around the translated text */
      border-radius: 8px; /* Rounded corners */
    }
  </style>
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <h1>Recipe Details</h1> <!-- Keep title centered -->

  <div class="main-content">
    <div class="main-container">
      <?php
        // Include the database configuration file
        include 'includes/config.php';

        // Get the recipe id from the URL
        $recipe_id = $_GET['id'];

        // Retrieve the recipe from the database
        $sql = "SELECT * FROM Recipes WHERE recipe_id=$recipe_id";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
          // Output data of the recipe
          $row = $result->fetch_assoc();
          echo '<div class="recipe-card-details">';
          echo '<h2>' . htmlspecialchars($row['title']) . '</h2>';
          echo '<img src="images/' . htmlspecialchars($row['image_url']) . '" alt="' . htmlspecialchars($row['title']) . '">';
          echo '<p><strong>Description:</strong> ' . htmlspecialchars($row['description']) . '</p>';
          echo '<p><strong>Ingredients:</strong> ' . htmlspecialchars($row['ingredients']) . '</p>';   
          echo '<p><strong>Instructions:</strong> ' . htmlspecialchars($row['instructions']) . '</p>';
          
          // Check if the user is logged in
          if (isset($_SESSION['username'])) {
              echo '<form method="POST" action="">';
              echo '<input type="hidden" name="recipe_id" value="' . $row['recipe_id'] . '">';
              echo '<button type="submit" class="fav-button" name="add_favorite">Add to favorites</button>';
              echo '<a href="' . htmlspecialchars($row['recipe_url']) . '" target="_blank" class="fav-button">Watch video</a>'; 
              echo '</form>';
          }
          echo '</div>';            
        } else {
            echo "No recipe found.";
        }
      ?>
    </div>

    <div class="translation-container">
      <h3>Translate Recipe</h3>
      <select id="language" class="translation-select">
        <option value="en">English</option>
        <option value="mr">Marathi</option>
        <option value="hi">Hindi</option>
        <option value="te">Telugu</option>
        <option value="gu">Gujarati</option>
        <option value="ta">Tamil</option>
      </select>
      <button class="translation-button" onclick="translateText()">Translate</button>

      <!-- Placeholder for translated recipe -->
      <div id="translated-output" class="translated-recipe" style="display: none;">
        <h4>Translated Recipe</h4>
        <p><strong>Description:</strong> <span id="translated-description"></span></p>
        <p><strong>Ingredients:</strong> <span id="translated-ingredients"></span></p>
        <p><strong>Instructions:</strong> <span id="translated-instructions"></span></p>
      </div>
    </div>
  </div>
  <!-- MAIN CONTENT -->

  <?php include 'includes/footer.php'; ?>

  <script>
    function addFavorite(recipeId) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "add_favorite.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("recipe_id=" + recipeId);
    }

    function translateText() {
      // Get selected language
      const language = document.getElementById("language").value;

      // Fetch the recipe text to translate using direct selectors
      const description = document.querySelector("p:nth-of-type(1)").textContent; // Description
      const ingredients = document.querySelector("p:nth-of-type(2)").textContent; // Ingredients
      const instructions = document.querySelector("p:nth-of-type(3)").textContent; // Instructions

      // Prepare the data for translation
      const texts = [description, ingredients, instructions];

      // Azure Translator API settings
      const endpoint = 'https://api.cognitive.microsofttranslator.com/translate?api-version=3.0';
      const subscriptionKey = '1f76e54d247349faaeaf20def1196ab4'; // Replace with your key
      const region = 'centralindia'; // Replace with your region

      // Prepare translation requests
      const requests = texts.map(text => {
        return fetch(`${endpoint}&to=${language}`, {
          method: 'POST',
          headers: {
            'Ocp-Apim-Subscription-Key': subscriptionKey,
            'Ocp-Apim-Subscription-Region': region,
            'Content-Type': 'application/json',
          },
          body: JSON.stringify([{ Text: text }])
        }).then(response => response.json());
      });

      // Handle the response for all translations
      Promise.all(requests)
        .then(responses => {
          const translatedTexts = responses.map(response => response[0].translations[0].text);
          document.getElementById("translated-description").textContent = translatedTexts[0];
          document.getElementById("translated-ingredients").textContent = translatedTexts[1];
          document.getElementById("translated-instructions").textContent = translatedTexts[2];
          document.getElementById("translated-output").style.display = "block";
        })
        .catch(error => {
          console.error('Error:', error);
          alert("Error during translation.");
        });
    }
  </script>

</body>
</html>

<?php
  // Add to favorites
  if (isset($_POST['add_favorite'])) {
    $recipe_id = $_POST['recipe_id'];
    $username = $_SESSION['username'];

    // Retrieve the user ID from the username
    $stmt = $conn->prepare("SELECT user_id FROM Users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
    $stmt->close();

    // Insert into Favorites table
    $stmt = $conn->prepare("INSERT INTO Favorites (user_id, recipe_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $recipe_id);

    if ($stmt->execute()) {
        echo "<script>alert('Recipe added to favorites successfully.');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
  }

  // Close the connection here, after all database operations are done
  $conn->close();
?>
