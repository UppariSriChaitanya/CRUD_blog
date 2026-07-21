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

    // Secure UPDATE using Prepared Statement
    $stmt = $conn->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        $stmt->close();
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Secure SELECT using Prepared Statement
$stmt = $conn->prepare("SELECT * FROM posts WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Post not found!");
}

$row = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
<div class="container">

<h2>Edit Post</h2>

<form method="POST" action="">

Title:<br>
<input type="text" name="title"
value="<?php echo htmlspecialchars($row['title']); ?>" required><br><br>

Content:<br>
<textarea name="content" rows="6" cols="40" required><?php echo htmlspecialchars($row['content']); ?></textarea><br><br>

<input type="submit" name="update" value="Update Post">

</form>

<br>

<a href="index.php">Back to Posts</a>

</div>
</body>
</html>