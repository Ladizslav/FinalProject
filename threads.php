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
        <h2>Threads</h2>

        <?php if (isset($_SESSION['user'])): ?>
            <a href="add_threads.php" class="add-thread-btn">Add New Thread</a>
        <?php endif; ?>

        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <div class="thread">
                <h3><?php echo $row['title']; ?></h3>
                <p><?php echo $row['content']; ?></p>
                <p>Posted by: <?php echo $row['username']; ?> | Date: <?php echo $row['created_at']; ?></p>
            </div>
        <?php endwhile; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
