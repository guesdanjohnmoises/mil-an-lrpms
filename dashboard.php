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

    <title>LRPMS Dashboard</title>

    <link rel="stylesheet" href="css/dashboard.css">

</head>

<body>

<div class="sidebar">

    <div class="logo-section">

        <img src="imgs/logo.png" width="80">

        <h2>LRPMS</h2>

        <p>Mil-an NHS</p>

    </div>

    <a href="dashboard.php">🏠 Dashboard</a>

    <a href="learners.php">📚 Learner Profiles</a>

    <a href="violation_encoding.php">⚠️ Violation Encoding</a>

    <a href="#">📋 Case Monitoring</a>

    <a href="pending_cases.php">⏳ Pending Cases</a>

    <a href="#">🧠 Guidance Intervention</a>

    <a href="#">📅 Teacher Availability</a>

    <a href="#">📊 Reports & Analytics</a>

    <a href="#">👥 User Management</a>

    <a href="logout.php">🚪 Logout</a>

</div>

<div class="main-content">

    <div class="top-header">

        <div>

            <h1>Mil-an National High School</h1>

            <p>Learner Rights and Protection Monitoring System</p>

        </div>

        <div class="user-box">

            <strong>
                <?php echo $_SESSION['username']; ?>
            </strong>

            <br>

            <?php echo $_SESSION['role']; ?>

        </div>

    </div>

    <div class="cards">

        <div class="card">

            <h2>0</h2>

            <p>Total Learners</p>

        </div>

        <div class="card">

            <h2>0</h2>

            <p>Total Violations</p>

        </div>

        <div class="card">

            <h2>0</h2>

            <p>Pending Cases</p>

        </div>

        <div class="card">

            <h2>0</h2>

            <p>Resolved Cases</p>

        </div>

    </div>

    <div class="activity-card">

        <h2>Recent Activities</h2>

        <ul>

            <li>Nazarene Del Rosario - Bullying Case Submitted</li>

            <li>Guesdan John Moises - Guidance Intervention Scheduled</li>

            <li>Case #001 Marked Resolved</li>

        </ul>

    </div>

</div>

</body>
</html>