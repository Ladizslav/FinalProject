<?php
session_start(); 
require_once "classes/DBC.php";
require_once "classes/User.php";
$username = "";
$errors = array();
// Zpracování formuláře registrace
if (isset($_POST['reg_user'])) {
    $username = isset($_POST['username']) ? $_POST['username'] : ''; 

    if (empty($username)) {
        $errors[] = "Jméno je vyžadováno";
    }

    $password_1 = isset($_POST['password_1']) ? $_POST['password_1'] : ''; // Získání hesla 
    $password_2 = isset($_POST['password_2']) ? $_POST['password_2'] : ''; // Získání 2. hesla 

    if (empty($password_1)) {
        $errors[] = "Heslo je vyžadováno";
    }
    if ($password_1 !== $password_2) {
        $errors[] = "Hesla se neshodují";
    }
    if (count($errors) === 0) {
        $user = User::registerUser($username, $password_1);

        if ($user) {
            $_SESSION['success'] = "Registrace se povedla"; 
            header('location: login.php'); 
            exit(); 
        } else {
            $errors[] = "Registrace se nepovedla";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrace</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?> 
    <div class="header">
        <h1>Registrace</h1>
    </div>
    <?php
    if (count($errors) > 0) {
        echo '<div class="error-messages">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
    ?>
    <form method="post" action="register.php">
        <div>
            <label>Jméno</label>
            <input type="text" name="username" value="<?php echo ($username); ?>">
        </div>
        <div>
            <label>Heslo</label>
            <input type="password" name="password_1">
        </div>
        <div>
            <label>Potvrdit heslo</label>
            <input type="password" name="password_2">
        </div>
        <div>
            <button type="submit" name="reg_user">Registrovat</button>
        </div>
        <p>
            Již členem? <a href="login.php">Přihlásit se</a>
        </p>
    </form>
<?php include 'footer.php'; ?>
</body>
</html>
