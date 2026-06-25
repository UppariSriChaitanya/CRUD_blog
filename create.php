<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts(title, content)
            VALUES('$title','$content')";

    if ($conn->query($sql) == TRUE) {
        echo "Post Added Successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>Create New Post</h2>

<form method="POST">

Title:<br>
<input type="text" name="title" required><br><br>

Content:<br>
<textarea name="content" rows="6" cols="40" required></textarea><br><br>

<input type="submit" name="submit" value="Add Post">

</form>

<br>

<div class="links">
<a class="button" href="dashboard.php">Back to Dashboard</a>
</div>
</div>
</body>
</html>