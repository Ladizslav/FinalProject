<?php
// Start or resume session
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
                <li><a class="btn" href="index.php">Ůvodní stránka</a></li>
                <?php if (isset($_SESSION['user'])): ?>
                    <li><a class="btn" href=" threads.php">Vlákna</a></li> 
                    <li><a class="btn" onclick="location.href='logout.php'">Odhlásit </a></li>
                <?php else: ?>
                    <li><a class="btn" href=" threads.php">Vlákna</a></li>
                    <li><a class="btn" href="register.php">Registrovat</a></li>
                    <li><a class="btn" href="login.php">Přihlásit</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
</body>
</html>
