<?php
session_start(); 

require_once "classes/DBC.php";
require_once "classes/User.php";

$username = "";
$errors = array();

if (isset($_POST['reg_user'])) {
    $username = $_POST['username'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    }

    $password_1 = $_POST['password_1'];
    $password_2 = $_POST['password_2'];

    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }

    if (count($errors) == 0) {
        $user = User::registerUser($username, $password_1);

        if ($user) {
            $_SESSION['success'] = "Registration successful"; 
            header('location: login.php');
            exit(); 
        } else {
            array_push($errors, "Registration failed");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<?php include 'header.php'; ?> 
    <div class="header">
        <h2>Register</h2>
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
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password_1">
        </div>
        <div class="input-group">
            <label>Confirm password</label>
            <input type="password" name="password_2">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="reg_user">Register</button>
        </div>
        <p>
            Already a member? <a href="login.php">Sign in</a>
        </p>
    </form>
</body>
</html>
<?php include 'footer.php'; ?>