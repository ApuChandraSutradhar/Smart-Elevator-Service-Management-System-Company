<?php
session_start();
require_once("../config/config.php");

if(!isset($_SESSION['t_id'])){
    header("Location: ../auth/technician_login.php");
    exit();
}

$t_id = $_SESSION['t_id'];

$pending_tasks = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE t_id=$t_id AND status='Pending'")->fetch_assoc()['c'];
$completed_tasks = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE t_id=$t_id AND status='Completed'")->fetch_assoc()['c'];
$total_tasks = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE t_id=$t_id")->fetch_assoc()['c'];
include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Technician Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
<h2 class="mb-4">👷 Technician Dashboard</h2>

<div class="row g-3">
  <div class="col-md-4">
    <div class="card shadow-sm text-center p-3">
      <h5>Total Tasks</h5>
      <p class="fs-4"><?= $total_tasks ?></p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm text-center p-3">
      <h5>Pending Tasks</h5>
      <p class="fs-4"><?= $pending_tasks ?></p>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card shadow-sm text-center p-3">
      <h5>Completed Tasks</h5>
      <p class="fs-4"><?= $completed_tasks ?></p>
    </div>
  </div>
</div>

<br>
<a href="my_tasks.php" class="btn btn-primary">➡ My Tasks</a>
<a href="../auth/logout.php" class="btn btn-secondary">🚪 Logout</a>

</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>
