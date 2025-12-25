<?php
session_start();
require_once("../config/config.php");
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

// Update technician assigned
if(isset($_POST['assign'])){
    $rid = intval($_POST['r_id']);
    $tid = intval($_POST['t_id']);
    $conn->query("UPDATE service_requests SET t_id='$tid', status='Assigned' WHERE r_id='$rid'");
}

// Fetch service requests
$requests = $conn->query("
    SELECT sr.r_id, sr.r_type, sr.status, sr.description, sr.location, t.t_name
    FROM service_requests sr
    LEFT JOIN technicians t ON sr.t_id=t.t_id
    ORDER BY sr.created_at DESC
");

// Fetch all technicians into an array
$techsArray = [];
$techsResult = $conn->query("SELECT * FROM technicians");
while($tech = $techsResult->fetch_assoc()){
    $techsArray[] = $tech;
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Manage Schedule</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<h2>🛠 Manage Schedule</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>
<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Type</th>
<th>Description</th>
<th>Location</th>
<th>Status</th>
<th>Technician</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row=$requests->fetch_assoc()): ?>
<tr>
<td><?= $row['r_id'] ?></td>
<td><?= $row['r_type'] ?></td>
<td><?= $row['description'] ?></td>
<td><?= $row['location'] ?></td>
<td><?= $row['status'] ?></td>
<td><?= $row['t_name'] ?? 'Unassigned' ?></td>
<td>
<form method="POST">
<input type="hidden" name="r_id" value="<?= $row['r_id'] ?>">
<select name="t_id" class="form-select mb-1" required>
<option value="">Select Technician</option>
<?php foreach($techsArray as $tech): ?>
<option value="<?= $tech['t_id'] ?>"><?= $tech['t_name'] ?></option>
<?php endforeach; ?>
</select>
<button type="submit" name="assign" class="btn btn-primary btn-sm">Assign</button>
</form>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</body>
</html>
<?php include('../includes/footer.php'); ?>