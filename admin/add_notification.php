<?php
session_start();
require_once("../config/config.php");

// Only admin can access
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/admin_login.php");
    exit();
}

$error = $success = "";

// Form submit
if(isset($_POST['submit'])){
    $c_id = $conn->real_escape_string($_POST['c_id']);
    $r_id = $conn->real_escape_string($_POST['r_id']);
    $channel = $conn->real_escape_string($_POST['channel']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO notifications (c_id, r_id, channel, message) 
            VALUES ('$c_id', '$r_id', '$channel', '$message')";

    if($conn->query($sql)){
        $success = "Notification added successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Fetch customers for dropdown
$customers = $conn->query("SELECT * FROM customers ORDER BY c_name ASC");

// Fetch service requests for dropdown
$requests = $conn->query("SELECT * FROM service_requests ORDER BY r_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Notification</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<h2>🔔 Add Notification</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>

<?php if($error) echo "<div class='alert alert-danger'>$error</div>"; ?>
<?php if($success) echo "<div class='alert alert-success'>$success</div>"; ?>

<form method="POST" class="card p-4 shadow-sm bg-white">
    <div class="mb-3">
        <label>Customer</label>
        <select name="c_id" class="form-select" required>
            <option value="">-- Select Customer --</option>
            <?php while($c = $customers->fetch_assoc()): ?>
                <option value="<?= $c['c_id'] ?>"><?= $c['c_name'] ?> (<?= $c['email'] ?>)</option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Related Service</label>
        <select name="r_id" class="form-select" required>
            <option value="">-- Select Service --</option>
            <?php while($r = $requests->fetch_assoc()): ?>
                <option value="<?= $r['r_id'] ?>">#<?= $r['r_id'] ?> - <?= $r['r_type'] ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="mb-3">
        <label>Channel</label>
        <select name="channel" class="form-select" required>
            <option value="">-- Select Channel --</option>
            <option value="App">App</option>
            <option value="Email">Email</option>
            <option value="SMS">SMS</option>
        </select>
    </div>

    <div class="mb-3">
        <label>Message</label>
        <textarea name="message" class="form-control" rows="3" required></textarea>
    </div>

    <button type="submit" name="submit" class="btn btn-primary w-100">Add Notification</button>
</form>
</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>