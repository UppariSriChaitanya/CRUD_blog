<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {

    $title = htmlspecialchars(trim($_POST['title']));
    $content = htmlspecialchars(trim($_POST['content']));

    // Server-side Validation
    if (empty($title) || empty($content)) {
        echo "<script>alert('All fields are required!');</script>";
    } else {

        // Prepared Statement
        $stmt = $conn->prepare("INSERT INTO posts(title, content) VALUES(?, ?)");
        $stmt->bind_param("ss", $title, $content);
        

        if ($stmt->execute()) {
            echo "<script>alert('Post Added Successfully!');</script>";
        } else {
            echo "<script>alert('Error: Unable to add post!');</script>";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Post</title>
    <link rel="stylesheet" href="auth.css">
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