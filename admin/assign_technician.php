<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}
require_once("../config/config.php");

// Assign technician
if(isset($_POST['assign'])){
    $rid = intval($_POST['r_id']);
    $tid = intval($_POST['t_id']);
    $conn->query("UPDATE service_requests SET t_id=$tid, status='Assigned' WHERE r_id=$rid");
}

// Fetch pending requests and available technicians
$requests = $conn->query("SELECT * FROM service_requests WHERE status='Pending'");
$techs = $conn->query("SELECT * FROM technicians WHERE available=1");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Assign Technician</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<h2 class="mb-4">🛠️ Assign Technicians</h2>
<table class="table table-bordered table-striped">
<tr><th>Request ID</th><th>Type</th><th>Description</th><th>Location</th><th>Assign</th></tr>
<?php while($req=$requests->fetch_assoc()): ?>
<tr>
<td><?= $req['r_id'] ?></td>
<td><?= $req['r_type'] ?></td>
<td><?= $req['description'] ?></td>
<td><?= $req['location'] ?></td>
<td>
<form method="post" class="d-flex">
<input type="hidden" name="r_id" value="<?= $req['r_id'] ?>">
<select name="t_id" class="form-select me-2" required>
<option value="">--Select Technician--</option>
<?php $techs->data_seek(0); while($t=$techs->fetch_assoc()): ?>
<option value="<?= $t['t_id'] ?>"><?= $t['t_name'] ?> (<?= $t['specialty'] ?>)</option>
<?php endwhile; ?>
</select>
<button type="submit" name="assign" class="btn btn-primary btn-sm">Assign</button>
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