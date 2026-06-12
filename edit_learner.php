<?php
session_start();
include 'db.php';

if(!isset($_SESSION['username']))
{
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"SELECT * FROM learners WHERE learner_id='$id'"
);

$row = mysqli_fetch_assoc($query);

if(isset($_POST['update_learner']))
{
    $lrn = $_POST['lrn'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $grade_level = $_POST['grade_level'];
    $section_name = $_POST['section_name'];
    $gender = $_POST['gender'];
    $adviser = $_POST['adviser'];
    $status = $_POST['status'];

    mysqli_query(
    $conn,

    "UPDATE learners SET

    lrn='$lrn',
    firstname='$firstname',
    middlename='$middlename',
    lastname='$lastname',
    grade_level='$grade_level',
    section_name='$section_name',
    gender='$gender',
    adviser='$adviser',
    status='$status'

    WHERE learner_id='$id'"
    );

    header("Location: learners.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit Learner</title>

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
    <a href="logout.php">🚪 Logout</a>

</div>

<div class="main-content">

<div class="card">

<h2>Edit Learner</h2>

<br>

<form method="POST">

LRN<br>
<input type="text" name="lrn"
value="<?php echo $row['lrn']; ?>" required>

<br><br>

First Name<br>
<input type="text" name="firstname"
value="<?php echo $row['firstname']; ?>" required>

<br><br>

Middle Name<br>
<input type="text" name="middlename"
value="<?php echo $row['middlename']; ?>">

<br><br>

Last Name<br>
<input type="text" name="lastname"
value="<?php echo $row['lastname']; ?>" required>

<br><br>

Grade Level<br>
<input type="text" name="grade_level"
value="<?php echo $row['grade_level']; ?>" required>

<br><br>

Section<br>
<input type="text" name="section_name"
value="<?php echo $row['section_name']; ?>" required>

<br><br>

Gender<br>

<select name="gender">

<option <?php if($row['gender']=="Male") echo "selected"; ?>>
Male
</option>

<option <?php if($row['gender']=="Female") echo "selected"; ?>>
Female
</option>

</select>

<br><br>

Adviser<br>
<input type="text" name="adviser"
value="<?php echo $row['adviser']; ?>">

<br><br>

Status<br>

<select name="status">

<option <?php if($row['status']=="Active") echo "selected"; ?>>
Active
</option>

<option <?php if($row['status']=="Inactive") echo "selected"; ?>>
Inactive
</option>

</select>

<br><br>

<button type="submit" name="update_learner">
Update Learner
</button>

<a href="learners.php">
Back
</a>

</form>

</div>

</div>

</body>
</html>