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
    <h1>Úvodní stránka</h1>
        <p>Vítejte na komunitní webové stránce, kde můžete objevovat, sdílet a zapojit se do vzrušujících diskuzí a obsahu. Ať už jste zde, abyste našli zajímavá vlákna, nebo sdíleli své vlastní nápady.</p>
        <h2>Funkce</h2>
        <ul>
            <li>Zapojte se do diskuzí s ostatními uživateli</li>
            <li>Sdílejte svá vlastní vlákna a nápady</li>
            <li>Buďte v obraze s nejnovějšími příspěvky komunity</li>
        </ul>

        <?php if (!isset($_SESSION['user'])): ?>
            <p>Jste zde poprvé? Neváhejte se <a href="register.php">zaregistrovat</a>. Už máte účet? <a href="login.php">Přihlaste se</a>, abyste získali přístup k dalším funkcím a zapojili se do konverzace.</p>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
