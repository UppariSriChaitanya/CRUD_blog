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
<link rel="stylesheet" href="auth.css">
</head>
<body>
<div class="container">

<h2>👋 Welcome, <?php echo $_SESSION['username']; ?></h2>

<div class="role-badge">
<?php
if($_SESSION['role'] == "admin")
{
    echo "👑 Admin";
}
else
{
    echo "✍️ Editor";
}
?>
</div>

<p class="welcome">
Manage your blog posts easily from your dashboard.
</p>

<p class="success">
You have successfully logged in.
</p>

<div class="button-group">

<a href="create.php" class="btn">Create Post</a>

<a href="index.php" class="btn">View Posts</a>

<a href="logout.php" class="btn">Logout</a>

</div>

</div>
</body>
</html>