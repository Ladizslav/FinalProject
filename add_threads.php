<?php
require_once "classes/DBC.php";
require_once "classes/User.php";
session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$user = $_SESSION['user'];
$user_id = $user->getId();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "classes/DBC.php"; // Připojení k databázi
    $user_id = $_SESSION['user']->getId(); // ID přihlášeného uživatele
    $content = $_POST['content']; // Obsah příspěvku
    $title = isset($_POST['title']) ? $_POST['title'] : ''; // Titulek vlákna

    if (!empty($content)) { // Ověření, zda byl zadán obsah vlákna
        // Získání uživatelského jména na základě ID uživatele
        $username = User::getUsernameById($user_id);

        if ($username !== null) { // Ověření, zda bylo jméno získáno
            // Přidání příspěvku do databáze
            $connection = DBC::getConnection();
            $query = "INSERT INTO threads (username, title, content) VALUES (?, ?, ?)";
            $statement = $connection->prepare($query);
            $statement->bind_param("sss", $username, $title, $content);
            $statement->execute();
            $statement->close();
            
            // Přesměrování na stránku s vlákny
            header('location: threads.php');
            exit();
        } else {
            // Uživatel s daným ID nebyl nalezen
            echo "User with ID $user_id was not found.";
        }
    } else {
        // Obsah vlákna není vyplněn
        echo "Please enter the content of the thread.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Thread</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div>
        <h1>Add Thread</h1>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-container">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title"><br> <!-- Přidání pole pro zadání titulku -->
            <label for="content">Content:</label><br>
            <textarea id="content" name="content" required></textarea><br>
            <input type="submit" value="Submit" class="btn">
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
