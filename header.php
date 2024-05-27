<?php
// Začínáme nebo obnovujeme session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Header</title>
</head>
<body>
    <header>
        <h1>Lesgo</h1>
            
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <!-- <li><a href="about.php">About</a></li> -->
                <?php if (isset($_SESSION['user'])): ?>
                    <!-- <li><a href="data.php">Data</a></li> -->
                    <li><a href="threads.php">Threads</a></li> 
                    <li><span class="logout-btn" onclick="location.href='logout.php'">Logout</span></li>
                <?php else: ?>
                    <li><a href="register.php">Register</a></li>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
