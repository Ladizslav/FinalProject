<?php
session_start();

require_once "classes/DBC.php";
require_once "classes/User.php";

$username = "";
$errors = array();

if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
    $waitTime = 60; 
    $lastAttemptTime = isset($_SESSION['last_failed_attempt_time']) ? $_SESSION['last_failed_attempt_time'] : 0;
    $currentTime = time();

    if ($currentTime - $lastAttemptTime < $waitTime) {
        $timeLeft = $waitTime - ($currentTime - $lastAttemptTime);
        array_push($errors, "Počkejte $timeLeft sekund před dalším pokusem.");
    }
}

if (isset($_POST['login_user'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username)) {
        array_push($errors, "Uzivatelske jmeno je povinne");
    }

    if (empty($password)) {
        array_push($errors, "Heslo je povinne");
    }

    if (count($errors) == 0) {
        $user = User::getUserByUsernameAndPassword($username, $password);

        if ($user) {
            $_SESSION['user'] = $user;
            header('location: index.php');
            exit();
        } else {
            array_push($errors, "Nespravne uzivatelske jmeno nebo heslo");
            recordFailedLoginAttempt($username);
            $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;
            if ($_SESSION['login_attempts'] >= 3) {
                $_SESSION['last_failed_attempt_time'] = time();
            }
        }
    }
}

function recordFailedLoginAttempt($username) {
    $logMessage = "Uzivatelske jmeno - $username, IP - {$_SERVER['REMOTE_ADDR']}, Cas - " . date('Y-m-d H:i:s') . PHP_EOL;
    $logFile = 'attempts.txt';
    file_put_contents($logFile, $logMessage, FILE_APPEND);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Prihlaseni</title>
</head>
<body>
<?php include 'header.php'; ?> 
<form method="post" action="login.php">
    <div class="header">
        <h2>Přihlašení</h2>
    </div>
    
    <?php foreach ($errors as $error): ?>
        <p><?php echo $error; ?></p>
    <?php endforeach; ?>

    <div>
        <label>Jméno</label>
        <input type="text" name="username" value="<?php echo $username; ?>">
    </div>
    <div>
        <label>Heslo</label>
        <input type="password" name="password">
    </div>
    <div>
        <button type="submit" class="btn" name="login_user">Přihlásit</button>
    </div>
    <p><div>
        Nejste členem? <a href="register.php">Registrace</a>
    </p></div>
</form>

<?php include 'footer.php'; ?>
</body>
</html>
