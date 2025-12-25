<?php
session_start();
require_once("../config/config.php");
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

// Stats
$total_customers = $conn->query("SELECT COUNT(*) as c FROM customers")->fetch_assoc()['c'];
$total_techs = $conn->query("SELECT COUNT(*) as c FROM technicians")->fetch_assoc()['c'];
$pending_requests = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE status='Pending'")->fetch_assoc()['c'];
$completed_requests = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE status='Completed'")->fetch_assoc()['c'];
$assigned_tasks = $conn->query("SELECT COUNT(*) as c FROM service_requests WHERE status='Assigned'")->fetch_assoc()['c'];

// Payments Calculation
$total_payments = $conn->query("SELECT SUM(amount) as s FROM payments WHERE status='Verified'")->fetch_assoc()['s'] ?? 0;
$today_payments = $conn->query("SELECT SUM(amount) as s FROM payments WHERE status='Verified' AND DATE(p_date) = CURDATE()")->fetch_assoc()['s'] ?? 0;
$weekly_payments = $conn->query("SELECT SUM(amount) as s FROM payments WHERE status='Verified' AND p_date >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)")->fetch_assoc()['s'] ?? 0;

// Date Filter
$filter_payments = 0;
if(isset($_POST['from_date']) && isset($_POST['to_date'])) {
    $from = $_POST['from_date'];
    $to = $_POST['to_date'];
    $res = $conn->query("SELECT SUM(amount) as s FROM payments WHERE status='Verified' AND DATE(p_date) BETWEEN '$from' AND '$to'");
    $filter_payments = $res->fetch_assoc()['s'] ?? 0;
}

// Payments List (show all verified payments)
$payments = $conn->query("SELECT * FROM payments WHERE status='Verified' ORDER BY p_date DESC");
?>
<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body { background:#f8f9fa; }
  .report-header {
      background: linear-gradient(90deg, #4facfe, #00f2fe);
      color: white;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 20px;
  }
  .card { border-radius: 12px; }
  .table thead { background:#4facfe; color:white; }
</style>
</head>
<body class="p-4">
<div class="report-header">
  <h2>📊 Admin Reports</h2>
  <a href="dashboard.php" class="btn btn-light btn-sm">⬅ Back</a>
</div>

<!-- Summary Cards -->
<div class="row g-3 mb-4">
  <div class="col-md-2">
    <div class="card p-3 text-center shadow-sm">
      <h6>Total Customers</h6>
      <p class="fs-5 fw-bold"><?= $total_customers ?></p>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card p-3 text-center shadow-sm">
      <h6>Total Technicians</h6>
      <p class="fs-5 fw-bold"><?= $total_techs ?></p>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card p-3 text-center shadow-sm">
      <h6>Pending Requests</h6>
      <p class="fs-5 fw-bold"><?= $pending_requests ?></p>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card p-3 text-center shadow-sm">
      <h6>Completed Requests</h6>
      <p class="fs-5 fw-bold"><?= $completed_requests ?></p>
    </div>
  </div>
  <div class="col-md-2">
    <div class="card p-3 text-center shadow-sm">
      <h6>Assigned Tasks</h6>
      <p class="fs-5 fw-bold"><?= $assigned_tasks ?></p>
    </div>
  </div>
</div>

<!-- Payments Section -->
<div class="card p-4 shadow-sm mb-4">
  <div class="d-flex justify-content-between">
    <h4>💰 Payments Report</h4>
    <button onclick="window.print()" class="btn btn-success btn-sm">🖨 Print</button>
  </div>
  <hr>
  <div class="row text-center">
    <div class="col-md-3">
      <div class="border rounded p-2">
        <h6>Today's Payments</h6>
        <p class="fs-5 text-success"><?= $today_payments ?> ৳</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="border rounded p-2">
        <h6>Last 7 Days</h6>
        <p class="fs-5 text-primary"><?= $weekly_payments ?> ৳</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="border rounded p-2">
        <h6>Total Verified</h6>
        <p class="fs-5 text-danger"><?= $total_payments ?> ৳</p>
      </div>
    </div>
    <div class="col-md-3">
      <div class="border rounded p-2">
        <h6>Filtered Payments</h6>
        <p class="fs-5 text-dark"><?= $filter_payments ?> ৳</p>
      </div>
    </div>
  </div>

  <!-- Date Filter Form -->
  <form method="POST" class="mt-3 row g-2">
    <div class="col-md-4">
      <input type="date" name="from_date" class="form-control" required>
    </div>
    <div class="col-md-4">
      <input type="date" name="to_date" class="form-control" required>
    </div>
    <div class="col-md-4">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </form>
</div>

<!-- Payments List -->
<div class="card p-4 shadow-sm">
  <h5>📄 All Verified Payments</h5>
  <div class="table-responsive mt-3">
    <table class="table table-bordered table-hover align-middle">
      <thead>
        <tr>
          <th>ID</th>
          <th>Customer ID</th>
          <th>Amount</th>
          <th>Date</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <?php if($payments->num_rows > 0): ?>
          <?php while($row = $payments->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= $row['customer_id'] ?></td>
              <td><?= $row['amount'] ?> ৳</td>
              <td><?= $row['p_date'] ?></td>
              <td><span class="badge bg-success"><?= $row['status'] ?></span></td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr><td colspan="5" class="text-center">No Verified Payments Found</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

</body>
</html>
<?php include('../includes/footer.php'); ?>