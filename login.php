<?php
session_start();
include "db.php";

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if($result->num_rows > 0)
    {
        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password']))
        {
            $_SESSION['username'] = $username;
            header("Location: dashboard.php");
            exit();
        }
        else
        {
            echo "Incorrect Password!";
        }
    }
    else
    {
        echo "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">

<h2>User Login</h2>

<form method="POST">

Username:<br>
<input type="text" name="username" required><br><br>

Password:<br>
<input type="password" name="password" required><br><br>

<input type="submit" name="login" value="Login">

</form>

<p>
Don't have an account?
<a href="register.php">Register</a>
</p>
</div>
</body>
</html>