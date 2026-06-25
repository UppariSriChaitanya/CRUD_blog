<?php
include "db.php";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Check if username already exists
    $check = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($check);

    if($result->num_rows > 0)
    {
        echo "<script>alert('Username already exists! Please choose another username.');</script>";
    }
    else
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users(username, password)
                VALUES('$username', '$hashedPassword')";

        if($conn->query($sql) === TRUE)
        {
            echo "<script>
                    alert('Registration Successful!');
                    window.location='login.php';
                  </script>";
        }
        else
        {
            echo "<script>alert('Registration Failed!');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Create Your Account</h2>

    <form method="POST">

        <label>Username</label>
        <input type="text" name="username" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <input type="submit" name="register" value="Register">

    </form>

    <p>
        Already have an account?
        <a href="login.php">Login</a>
    </p>

    <hr style="margin-top:30px;">

    <p style="color:gray;">
        CRUD Blog Application © 2026
    </p>

</div>

</body>
</html>