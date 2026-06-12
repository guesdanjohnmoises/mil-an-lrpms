<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Pending Cases</title>

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
<a href="pending_cases.php">⏳ Pending Cases</a>
<a href="logout.php">🚪 Logout</a>

</div>

<div class="main-content">

<div class="card">

<h2>Pending Cases</h2>

<br>

<table border="1" width="100%" cellpadding="10">

<tr>

<th>No.</th>
<th>Learner</th>
<th>Violation</th>
<th>Level</th>
<th>Status</th>
<th>Action</th>

</tr>

<?php

$query = mysqli_query($conn,

"SELECT violations.*,
learners.firstname,
learners.lastname

FROM violations

INNER JOIN learners

ON violations.learner_id =
learners.learner_id

ORDER BY violation_id DESC");

$count = 1;

while($row = mysqli_fetch_assoc($query))
{
?>

<tr>

<td><?php echo $count; ?></td>

<td>
<?php
echo $row['lastname'].", ".
$row['firstname'];
?>
</td>

<td><?php echo $row['violation_type']; ?></td>

<td><?php echo $row['violation_level']; ?></td>

<td><?php echo $row['status']; ?></td>

<td>

<a href="#">
Review
</a>

</td>

</tr>

<?php
$count++;
}
?>

</table>

</div>

</div>

</body>
</html>