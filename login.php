<?php
session_start();

require_once "classes/DBC.php";
require_once "classes/User.php";

$username = "";
$errors = array();

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        array_push($errors, "Username is required");
    }

    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $user = User::getUserByUsernameAndPassword($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header('location: welcome.php');
            exit();
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<?php include 'header.php'; ?> 
    <div class="header">
        <h2>Login</h2>
    </div>
    
    <form method="post" action="login.php">
        <div class="input-group">
            <label>Username</label>
            <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
            <label>Password</label>
            <input type="password" name="password">
        </div>
        <div class="input-group">
            <button type="submit" class="btn" name="login_user">Login</button>
        </div>
        <p>
            Not a member? <a href="register.php">Register</a>
        </p>
    </form>
<?php include 'footer.php'; ?>
</body>
</html>
