<?php
session_start();
require_once("../config/config.php");

// Only customer can access
if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){
    header("Location: ../auth/login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

// Fetch notifications for this customer
$sql = "
SELECT n.n_id, n.channel, n.message, sr.r_type, sr.r_id
FROM notifications n
LEFT JOIN service_requests sr ON n.r_id = sr.r_id
WHERE n.c_id = '$customer_id'
ORDER BY n.n_id DESC
";
$notifications = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Notifications</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: #f0f2f5;
    }
    .notif-card {
        border-left: 5px solid #007bff;
        padding: 15px;
        margin-bottom: 10px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .notif-channel {
        font-size: 0.85rem;
        color: #555;
    }
</style>
</head>
<body>
<div class="container py-4">
<h2>🔔 Notifications</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back to Dashboard</a>

<?php if($notifications->num_rows > 0): ?>
    <?php while($row = $notifications->fetch_assoc()): ?>
        <div class="notif-card">
            <h5>Service: <?= $row['r_type'] ?> (#<?= $row['r_id'] ?>)</h5>
            <p><?= $row['message'] ?></p>
            <span class="notif-channel">Channel: <?= $row['channel'] ?></span>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p class="text-center text-muted">No notifications found.</p>
<?php endif; ?>

</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>