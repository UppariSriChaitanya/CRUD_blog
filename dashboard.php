<?php
session_start();

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Dashboard</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>👋 Welcome, <?php echo $_SESSION['username']; ?></h2>
<p>Manage your blog posts easily from your dashboard.</p>

<p>You have successfully logged in.</p>

<div class="links">
    <a class="button" href="create.php">Create Post</a>

    <a class="button" href="index.php">View Posts</a>

    <a class="button" href="logout.php">Logout</a>
</div>

</div>
</body>
</html>