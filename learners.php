<?php
session_start();
include 'db.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

/* DELETE LEARNER */
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);

    $stmt = $conn->prepare("DELETE FROM learners WHERE learner_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: learners.php");
        exit();
    }
}

/* SAVE LEARNER */
if (isset($_POST['save_learner'])) {

    $lrn = trim($_POST['lrn']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $lastname = trim($_POST['lastname']);
    $grade_level = trim($_POST['grade_level']);
    $section_name = trim($_POST['section_name']);
    $gender = trim($_POST['gender']);
    $adviser = trim($_POST['adviser']);

    /* CHECK DUPLICATE LRN */
    $check = $conn->prepare(
        "SELECT learner_id FROM learners WHERE lrn = ?"
    );
    $check->bind_param("s", $lrn);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('LRN already exists!');</script>";
    } else {

        $stmt = $conn->prepare("
            INSERT INTO learners
            (
                lrn,
                firstname,
                middlename,
                lastname,
                grade_level,
                section_name,
                gender,
                adviser
            )
            VALUES
            (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $stmt->bind_param(
            "ssssssss",
            $lrn,
            $firstname,
            $middlename,
            $lastname,
            $grade_level,
            $section_name,
            $gender,
            $adviser
        );

        if ($stmt->execute()) {
            header("Location: learners.php");
            exit();
        } else {
            die("Insert Error: " . $conn->error);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Learner Profiles</title>
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

<h1>Learner Profiles</h1>

<br>

<div class="card">

<form method="POST">

    <h3>Add Learner</h3>

    <br>

    LRN<br>
    <input type="text" name="lrn" required>

    <br><br>

    First Name<br>
    <input type="text" name="firstname" required>

    <br><br>

    Middle Name<br>
    <input type="text" name="middlename">

    <br><br>

    Last Name<br>
    <input type="text" name="lastname" required>

    <br><br>

    Grade Level<br>
    <input type="text" name="grade_level" required>

    <br><br>

    Section<br>
    <input type="text" name="section_name" required>

    <br><br>

    Gender<br>

    <select name="gender">
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <br><br>

    Adviser<br>
    <input type="text" name="adviser">

    <br><br>

    <button type="submit" name="save_learner">
        Save Learner
    </button>

</form>

</div>

<br>

<div class="card">

<h3>Learner List</h3>

<form method="GET">

    <input
        type="text"
        name="search"
        placeholder="Search learner..."
        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">

    <button type="submit">Search</button>

</form>

<br><br>

<table border="1" width="100%" cellpadding="10">

<tr>
    <th>No.</th>
    <th>LRN</th>
    <th>Name</th>
    <th>Grade Level</th>
    <th>Section</th>
    <th>Gender</th>
    <th>Status</th>
    <th>Action</th>
</tr>

<?php

if (isset($_GET['search']) && !empty($_GET['search'])) {

    $search = "%" . $_GET['search'] . "%";

    $stmt = $conn->prepare("
        SELECT *
        FROM learners
        WHERE firstname LIKE ?
        OR lastname LIKE ?
        OR lrn LIKE ?
        ORDER BY lastname ASC
    ");

    $stmt->bind_param(
        "sss",
        $search,
        $search,
        $search
    );

    $stmt->execute();
    $query = $stmt->get_result();

} else {

    $query = $conn->query(
        "SELECT * FROM learners ORDER BY lastname ASC"
    );
}

$count = 1;

while ($row = $query->fetch_assoc()) {
?>

<tr>

    <td><?php echo $count; ?></td>

    <td><?php echo htmlspecialchars($row['lrn']); ?></td>

    <td>
        <?php
        echo htmlspecialchars(
            $row['lastname'] . ", " .
            $row['firstname'] . " " .
            $row['middlename']
        );
        ?>
    </td>

    <td><?php echo htmlspecialchars($row['grade_level']); ?></td>

    <td><?php echo htmlspecialchars($row['section_name']); ?></td>

    <td><?php echo htmlspecialchars($row['gender']); ?></td>

    <td>
        <?php echo htmlspecialchars($row['status'] ?? 'Active'); ?>
    </td>

    <td>

        <a href="edit_learner.php?id=<?php echo $row['learner_id']; ?>">
            Edit
        </a>

        |

        <a
            href="learners.php?delete=<?php echo $row['learner_id']; ?>"
            onclick="return confirm('Delete this learner?')">
            Delete
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