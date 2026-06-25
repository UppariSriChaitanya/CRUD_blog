<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sql = "SELECT * FROM posts";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Posts</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>All Blog Posts</h2>

<a class="button" href="create.php">Create New Post</a>
<br><br>

<table border="1" cellpadding="10">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Content</th>
        <th>Created At</th>
        <th>Actions</th>
    </tr>

    <?php
    while($row = $result->fetch_assoc())
    {
    ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['title']; ?></td>
        <td><?php echo $row['content']; ?></td>
        <td><?php echo $row['created_at']; ?></td>
        <td>
            <a class="action-edit" href="edit.php?id=<?php echo $row['id']; ?>">✏ Edit</a>
            <a class="action-delete" href="delete.php?id=<?php echo $row['id']; ?>"onclick="return confirm('Are you sure you want to delete this post?');">
   🗑 Delete
</a>
        </td>
    </tr>

    <?php
    }
    ?>

</table>

<br>

<a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>