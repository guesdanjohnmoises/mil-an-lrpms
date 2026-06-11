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
</head>

<body>

<h1>Welcome to Learner Rights and Protection Monitoring System</h1>

<h2>
Logged in as:
<?php echo $_SESSION['username']; ?>
</h2>

<h3>
Role:
<?php echo $_SESSION['role']; ?>
</h3>

<br>

<a href="logout.php">Logout</a>

</body>
</html>