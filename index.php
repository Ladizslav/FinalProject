<?php 
require_once "classes/DBC.php";
require_once "classes/User.php";
session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Main menu</title>
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div>
        <h1>Welcome to Our Website</h1>
        <?php if (isset($_SESSION['user'])): ?>
            <p>Hello, <?php echo htmlspecialchars($_SESSION['user']->getName(), ENT_QUOTES, 'UTF-8'); ?>!</p>
        <?php else: ?>
        <?php endif; ?>
        xd
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
