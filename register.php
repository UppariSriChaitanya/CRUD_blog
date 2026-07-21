<?php
include "db.php";

if(isset($_POST['register']))
{
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Server-side Validation
    if(empty($username) || empty($password))
    {
        echo "<script>alert('All fields are required!');</script>";
    }
    elseif(strlen($username) < 3)
    {
        echo "<script>alert('Username must be at least 3 characters long!');</script>";
    }
    elseif(strlen($password) < 6)
    {
        echo "<script>alert('Password must be at least 6 characters long!');</script>";
    }
    else
    {
        // Check if username already exists (Prepared Statement)
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0)
        {
            echo "<script>alert('Username already exists! Please choose another username.');</script>";
        }
        else
        {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Insert user using Prepared Statement
            $stmt = $conn->prepare("INSERT INTO users(username, password, role) VALUES (?, ?, 'editor')");
            $stmt->bind_param("ss", $username, $hashedPassword);

            if($stmt->execute())
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

        $stmt->close();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
    <link rel="stylesheet" href="auth.css">
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