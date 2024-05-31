<?php
session_start();
require_once "classes/DBC.php";

$connection = DBC::getConnection();
$query = "SELECT * FROM threads ORDER BY created_at DESC";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Threads</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php include 'header.php'; ?> 

    <div class="thread-container">
        <h1>Vlákna</h1>

        <?php if (isset($_SESSION['user'])): ?>
            <form action="add_threads.php" method="GET">
                <button type="submit" class="btn">Přidat nové vlákno</button>
            </form>
        <?php endif; ?>
        <p></p>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="thread">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['content']; ?></p>
                <p>Od: <?php echo $row['username']; ?> | Datum: <?php echo $row['created_at']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
