<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

if(isset($_POST['save_violation']))
{
    $learner_id = $_POST['learner_id'];
    $violation_date = $_POST['violation_date'];
    $violation_type = $_POST['violation_type'];
    $violation_level = $_POST['violation_level'];
    $description = $_POST['description'];

    $reported_by = $_SESSION['username'];

    mysqli_query($conn,"
    INSERT INTO violations
    (
        learner_id,
        violation_date,
        violation_type,
        violation_level,
        description,
        reported_by
    )
    VALUES
    (
        '$learner_id',
        '$violation_date',
        '$violation_type',
        '$violation_level',
        '$description',
        '$reported_by'
    )
    ");
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Violation Encoding</title>

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
<a href="logout.php">🚪 Logout</a>

</div>

<div class="main-content">

<div class="card">

<h2>Encode Violation</h2>

<br>

<form method="POST">

Learner<br>

<select name="learner_id" required>

<option value="">Select Learner</option>

<?php

$learners = mysqli_query(
$conn,
"SELECT * FROM learners ORDER BY lastname ASC"
);

while($learner = mysqli_fetch_assoc($learners))
{
?>

<option value="<?php echo $learner['learner_id']; ?>">

<?php
echo $learner['lastname'].", ".
     $learner['firstname'];
?>

</option>

<?php
}
?>

</select>

<br><br>

Violation Date<br>

<input type="date"
name="violation_date"
required>

<br><br>

Violation Type<br>

<select name="violation_type">

<option>Bullying</option>
<option>Fighting</option>
<option>Disrespect</option>
<option>Tardiness</option>
<option>Absenteeism</option>

</select>

<br><br>

Violation Level<br>

<select name="violation_level">

<option>Minor</option>
<option>Major</option>
<option>Grave</option>

</select>

<br><br>

Description<br>

<textarea
name="description"
rows="4"
cols="50"></textarea>

<br><br>

<button type="submit"
name="save_violation">

Save Violation

</button>

</form>

</div>

<br>

<div class="card">

<h2>Violation Records</h2>

<br>

<table border="1" width="100%" cellpadding="10">

<tr>

<th>No.</th>
<th>Learner</th>
<th>Date</th>
<th>Violation</th>
<th>Level</th>
<th>Status</th>

</tr>

<?php

$query = mysqli_query(
$conn,

"SELECT violations.*,
learners.firstname,
learners.lastname

FROM violations

INNER JOIN learners

ON violations.learner_id =
learners.learner_id

ORDER BY violation_id DESC"
);

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

<td><?php echo $row['violation_date']; ?></td>

<td><?php echo $row['violation_type']; ?></td>

<td><?php echo $row['violation_level']; ?></td>

<td><?php echo $row['status']; ?></td>

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