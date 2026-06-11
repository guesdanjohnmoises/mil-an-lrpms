<?php
session_start();
include 'db.php';

if(isset($_POST['login']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query(
        $conn,
        "SELECT * FROM users
         WHERE username='$username'
         AND password='$password'"
    );

    if(mysqli_num_rows($query) > 0)
    {
        $user = mysqli_fetch_assoc($query);

        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: dashboard.php");
        exit();
    }
    else
    {
        $error = "Invalid Username or Password";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Mil-an National High School</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="overlay">

    <div class="login-container">

        <img src="imgs/logo.png" class="logo">

        <h1>Mil-an National High School</h1>

        <p class="subtitle">
            Learner Rights and Protection Monitoring System
        </p>

        <?php if(isset($error)) { ?>
            <p style="color:red;"><?php echo $error; ?></p>
        <?php } ?>

        <form action="" method="POST">

            <input type="text"
                   placeholder="Username"
                   name="username"
                   required>

            <input type="password"
                   placeholder="Password"
                   name="password"
                   required>

            <button type="submit" name="login">
                Login
            </button>

        </form>

    </div>

</div>

</body>
</html>