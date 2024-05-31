<?php
session_start(); 

require_once "classes/DBC.php";
require_once "classes/User.php";

$username = "";
$errors = array();

if (isset($_POST['reg_user'])) {
    $username = $_POST['username'];

    if (empty($username)) {
        array_push($errors, "Jméno je vyžadováno");
    }

    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($password_1)) {
        array_push($errors, "Heslo je vyžadováno");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "Hesla se neshodují");
    }

    if (count($errors) == 0) {
        $user = User::registerUser($username, $password_1);

        if ($user) {
            $_SESSION['success'] = "Registrace se povedla"; 
            header('location: login.php');
            exit(); 
        } else {
            array_push($errors, "Registrace se nepovedla");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrace</title>
</head>
<body>
<?php include 'header.php'; ?> 
    <div class="header">
        <h1>Registrace</h2>
    </div>

    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="success-message">' . $_SESSION['success'] . '</div>';
        unset($_SESSION['success']);
    }

    if (count($errors) > 0) {
        echo '<div class="error-messages">';
        foreach ($errors as $error) {
            echo '<p>' . $error . '</p>';
        }
        echo '</div>';
    }
    ?>
    
    <form method="post" action="register.php">
        <div>
            <label>Jméno</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
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
            <button type="submit" class="btn" name="reg_user">Registrovat</button>
        </div>
        <p><div>
            Již členem? <a href="login.php">Přihlásit se</a>
        </p></div>
    </form>
</body>
</html>
<?php include 'footer.php'; ?>