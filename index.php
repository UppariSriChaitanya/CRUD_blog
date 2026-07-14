<?php
session_start();
include "db.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$search = isset($_GET['search']) ? $_GET['search'] : '';

$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Fetch posts
$sql = "SELECT * FROM posts
        WHERE title LIKE '%$search%'
        OR content LIKE '%$search%'
        ORDER BY created_at 
        LIMIT $start, $limit";

$result = $conn->query($sql);

// Count total posts
$countSql = "SELECT COUNT(*) AS total FROM posts
             WHERE title LIKE '%$search%'
             OR content LIKE '%$search%'";

$countResult = $conn->query($countSql);
$totalPosts = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalPosts / $limit);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="style.css">
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-dark bg-primary shadow">
    <div class="container">
        <a class="navbar-brand fw-bold text-dark" href="#">
            <i class="bi bi-journal-richtext"></i> Blog Manager
        </a>

        <a href="logout.php" class="btn btn-light">
            <i class="bi bi-box-arrow-right"></i> Logout
        </a>
    </div>
</nav>

<div class="container mt-5">

    <!-- Welcome Card -->
    <div class="card shadow border-0 mb-4">
        <div class="card-body text-center">
            <h2 class="fw-bold">Welcome to Blog Management System</h2>
            <p class="text-muted">
                Create, search, edit and manage your blog posts easily.
            </p>
        </div>
    </div>

    <!-- Search -->
    <form method="GET" class="row g-3 mb-4">

        <div class="col-md-10">
            <input type="text"
                name="search"
                class="form-control"
                placeholder="Search title or content..."
                value="<?php echo $search; ?>">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary w-100">
                <i class="bi bi-search"></i> Search
            </button>
        </div>
        <div class="col-md-2">
        <a href="index.php" class="btn btn-secondary w-100">
        <i class="bi bi-house-door-fill"></i> Dashboard
        </a>
     </div>

    </form>

    <!-- Create Button -->
    <a href="create.php" class="btn btn-success mb-4">
        <i class="bi bi-plus-circle"></i> Create New Post
    </a>

    <!-- Table -->
    <table class="table table-bordered table-hover shadow">

        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Content</th>
                <th>Created At</th>
                <th width="180">Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php while($row = $result->fetch_assoc()) { ?>

            <tr>

                <td><?php echo $row['id']; ?></td>

                <td><?php echo $row['title']; ?></td>

                <td><?php echo $row['content']; ?></td>

                <td><?php echo $row['created_at']; ?></td>

                <td>

                    <a href="edit.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-warning btn-sm">

                        <i class="bi bi-pencil-square"></i> Edit

                    </a>

                    <a href="delete.php?id=<?php echo $row['id']; ?>"
                        class="btn btn-danger btn-sm"
                        onclick="return confirm('Delete this post?')">

                        <i class="bi bi-trash"></i> Delete

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

    <!-- Pagination -->
    <nav>

        <ul class="pagination justify-content-center">

            <?php for($i = 1; $i <= $totalPages; $i++) { ?>

                <li class="page-item <?php if($page == $i) echo 'active'; ?>">

                    <a class="page-link"
                       href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>">

                        <?php echo $i; ?>

                    </a>

                </li>

            <?php } ?>

        </ul>

    </nav>

</div>

<!-- Footer -->
<footer class="bg-primary text-white text-center p-3 mt-5">

    © 2026 Blog Management System

    <br>

    Developed using PHP • MySQL • Bootstrap

</footer>

</body>
</html>