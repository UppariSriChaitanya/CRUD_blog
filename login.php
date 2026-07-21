<?php
session_start();
include "db.php";

if(isset($_POST['login']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepared Statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0)
    {
        $user = $result->fetch_assoc();   // Fetch user data first

        if(password_verify($password, $user['password']))
        {
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header("Location: dashboard.php");
            exit();
        }
        else
        {
            $error= "Incorrect Password!";
        }
    }
    else
    {
        $error ="User not found!";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="auth.css">
</head>
<body>
<div class="container">

<h2>User Login</h2>

<form method="POST">

<?php if(isset($error)){ ?>
    <div class="error-msg">
        <?php echo htmlspecialchars($error); ?>
    </div>
<?php } ?>

<label for="username">Username:</label>
<input type="text" id="username" name="username" required>

<label for="password">Password:</label>
<input type="password" id="password" name="password" required>

<input type="submit" name="login" value="Login">

</form>

<p>
Don't have an account?
<a href="register.php">Register</a>
</p>
</div>
</body>
</html>