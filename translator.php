<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the text and language from the form, and escape them for security
    $textToTranslate = escapeshellarg($_POST['textToTranslate']);
    $targetLanguage = escapeshellarg($_POST['language']);

    // Path to your Python script
    $pythonScript = 'C:\\xampp\\htdocs\\recipe_website\\includes\\azure_translate.py';

    // Command to call Python script with the text and language as arguments
    $command = escapeshellcmd("python $pythonScript $textToTranslate $targetLanguage");

    // Execute the Python script and capture the output (translated text)
    $output = shell_exec($command);

    // Display the translated text (if any)
    echo "Translated Text: " . htmlspecialchars($output);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Translation Page</title>
</head>
<body>
    <h1>Translate Text</h1>
    <form method="POST" action="translator.php">
        <!-- Input field for the text to be translated -->
        <input type="text" name="textToTranslate" placeholder="Enter text" required>

        <!-- Dropdown for selecting the target language -->
        <select name="language">
            <option value="fr">French</option>
            <option value="es">Spanish</option>
            <option value="de">German</option>
        </select>

        <!-- Submit button to trigger the translation -->
        <button type="submit">Translate</button>
    </form>

    <!-- Output the translated text (if available) -->
    <p><?php if (isset($output)) echo htmlspecialchars($output); ?></p>
</body>
</html>
