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
    $content = $_POST['content'] ?? ''; 
    $title = $_POST['title'] ?? ''; 

    if (empty($content)) { 
        echo "Prosím napište něco do kontentu.";
        exit();
    }
    
    $username = User::getUsernameById($user_id);

    if ($username === null) { 
        echo "Uživatel s tímhle ID $user_id nebyl nalezen.";
        exit();
    }

    $connection = DBC::getConnection();
    $query = "INSERT INTO threads (username, title, content) VALUES ('$username', '$title', '$content')";
    mysqli_query($connection, $query);
    
    header('location: threads.php');
    exit();
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
        <h1>Přidat vlákno </h1>

        <form action="<?php echo ($_SERVER["PHP_SELF"]); ?>" method="post" >
            <label for="title">Název:</label><br>
            <input type="text" id="title" name="title"><br>
            <label for="content">Kontent:</label><br>
            <textarea id="content" name="content" required></textarea><br>
            <input type="submit" value="Submit" class="btn">
        </form>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
