<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}
require_once("../config/config.php");

// Update request status
if(isset($_POST['update_status'])){
    $rid = intval($_POST['r_id']);
    $status = $_POST['status'];
    $conn->query("UPDATE service_requests SET status='$status' WHERE r_id=$rid");
}

// Fetch requests with customer & technician info
$requests = $conn->query("SELECT sr.*, c.c_name, t.t_name 
FROM service_requests sr
LEFT JOIN customers c ON sr.c_id=c.c_id
LEFT JOIN technicians t ON sr.t_id=t.t_id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Requests</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<h2 class="mb-4">📋 Manage Requests</h2>
<table class="table table-bordered table-striped">
<tr><th>ID</th><th>Customer</th><th>Technician</th><th>Type</th><th>Status</th><th>Update</th></tr>
<?php while($r=$requests->fetch_assoc()): ?>
<tr>
<td><?= $r['r_id'] ?></td>
<td><?= $r['c_name'] ?></td>
<td><?= $r['t_name'] ?: 'Not Assigned' ?></td>
<td><?= $r['r_type'] ?></td>
<td><?= $r['status'] ?></td>
<td>
<form method="post" class="d-flex">
<input type="hidden" name="r_id" value="<?= $r['r_id'] ?>">
<select name="status" class="form-select me-2">
<option value="Pending" <?= $r['status']=='Pending'?'selected':'' ?>>Pending</option>
<option value="Assigned" <?= $r['status']=='Assigned'?'selected':'' ?>>Assigned</option>
<option value="Completed" <?= $r['status']=='Completed'?'selected':'' ?>>Completed</option>
</select>
<button type="submit" name="update_status" class="btn btn-success btn-sm">Update</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>