<?php
require_once "classes/DBC.php";
require_once "classes/User.php";
session_start();

if (!isset($_SESSION['user'])) {
    header('location: login.php');
    exit();
}

$user = $_SESSION['user'];
?>

<?php include 'header.php'; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8'); ?>!</h1>
    
</body>
</html>

<?php include 'footer.php'; ?> 
