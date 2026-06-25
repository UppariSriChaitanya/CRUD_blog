<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    die("No post selected!");
}

$id = (int)$_GET['id'];

if (isset($_POST['update'])) {

    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title='$title', content='$content' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$sql = "SELECT * FROM posts WHERE id=$id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Post not found!");
}

$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>Edit Post</h2>

<form method="POST" action="">

Title:<br>
<input type="text" name="title" value="<?php echo $row['title']; ?>" required><br><br>

Content:<br>
<textarea name="content" rows="6" cols="40" required><?php echo $row['content']; ?></textarea><br><br>

<input type="submit" name="update" value="Update Post">

</form>

<br>

<a href="index.php">Back to Posts</a>
</div>
</body>
</html>