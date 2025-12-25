<?php
session_start();
include("../config/config.php");
if(!isset($_SESSION['admin_id'])){
    header("Location: ../auth/admin_login.php");
    exit();
}

// Verify payment
if(isset($_GET['verify_id'])){
    $pid = intval($_GET['verify_id']);
    $conn->query("UPDATE payments SET status='Verified' WHERE p_id='$pid'");
    header("Location: verify_payment.php");
    exit();
}

// Reject payment
if(isset($_GET['reject_id'])){
    $pid = intval($_GET['reject_id']);
    $conn->query("UPDATE payments SET status='Rejected' WHERE p_id='$pid'");
    header("Location: verify_payment.php");
    exit();
}

// Fetch pending payments
$payments = $conn->query("
SELECT p.p_id, p.amount, p.method, p.p_date, c.c_name, sr.r_type
FROM payments p
JOIN customers c ON p.c_id=c.c_id
JOIN service_requests sr ON p.r_id=sr.r_id
WHERE p.status='Pending'
");
?>
<!DOCTYPE html>
<html>
<head>
<title>Verify Payments</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>💳 Verify Payments</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>
<?php if($payments->num_rows>0): ?>
<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Customer</th>
<th>Service</th>
<th>Amount</th>
<th>Method</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row=$payments->fetch_assoc()): ?>
<tr>
<td><?= $row['p_id'] ?></td>
<td><?= $row['c_name'] ?></td>
<td><?= $row['r_type'] ?></td>
<td><?= $row['amount'] ?> ৳</td>
<td><?= $row['method'] ?></td>
<td><?= $row['p_date'] ?></td>
<td>
<a href="?verify_id=<?= $row['p_id'] ?>" class="btn btn-success btn-sm">✅ Verify</a>
<a href="?reject_id=<?= $row['p_id'] ?>" class="btn btn-danger btn-sm">❌ Reject</a>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<?php else: ?>
<p class="text-center text-muted">No pending payments found.</p>
<?php endif; ?>
</body>
</html>
<?php include('../includes/footer.php'); ?>