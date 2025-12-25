<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}
$admin_name = $_SESSION['admin_name'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elevator_system";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch statistics
$sql = "SELECT 
            COUNT(*) AS total_requests,
            SUM(CASE WHEN status='Completed' THEN 1 ELSE 0 END) AS completed_requests,
            SUM(CASE WHEN status='Pending' THEN 1 ELSE 0 END) AS pending_requests,
            SUM(CASE WHEN status='Assigned' THEN 1 ELSE 0 END) AS assigned_requests
        FROM service_requests";
$result = $conn->query($sql);
$data = $result->fetch_assoc();

// Include header
include('../includes/header.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f5f6fa; }
    .card-hover {
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
      border-radius: 15px;
      min-height: 150px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.3rem;
      font-weight: 600;
    }
    .card-hover:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .logo-img { height: 50px; object-fit: contain; }
    a { color: inherit; text-decoration: none; }
    .stats-card {
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      font-weight: bold;
      color: white;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    .stats-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }
    .stats-value {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
     Smart Elevator Service & Management System
    </a>
    <div class="d-flex align-items-center">
      <span class="navbar-text text-white me-3">Welcome, <?= htmlspecialchars($admin_name) ?> 👋</span>
      <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="container py-5">

  <h2 class="mb-4 text-center">Admin Panel</h2>

  <!-- Statistics Section -->
  <div class="row g-4 mb-5">
    <div class="col-lg-3 col-md-6">
      <a href="manage_requests.php">
        <div class="stats-card bg-primary shadow-sm">
          <div class="stats-value"><?= $data['total_requests'] ?></div>
          Total Requests
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-md-6">
      <a href="manage_requests.php?filter=completed">
        <div class="stats-card bg-success shadow-sm">
          <div class="stats-value"><?= $data['completed_requests'] ?></div>
          Completed Tasks
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-md-6">
      <a href="manage_requests.php?filter=pending">
        <div class="stats-card bg-warning shadow-sm">
          <div class="stats-value"><?= $data['pending_requests'] ?></div>
          Pending Requests
        </div>
      </a>
    </div>
    <div class="col-lg-3 col-md-6">
      <a href="manage_requests.php?filter=assigned">
        <div class="stats-card bg-info shadow-sm">
          <div class="stats-value"><?= $data['assigned_requests'] ?></div>
          Assigned Tasks
        </div>
      </a>
    </div>
  </div>

  <!-- Feature Cards -->
  <div class="row g-4">

    <div class="col-lg-4 col-md-6">
      <a href="manage_users.php">
        <div class="card card-hover bg-primary text-white shadow-sm">
          👤 Manage Users
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="assign_technician.php">
        <div class="card card-hover bg-success text-white shadow-sm">
          🛠️ Assign Technician
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="manage_requests.php">
        <div class="card card-hover bg-warning text-white shadow-sm">
          📋 Manage Requests
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="verify_payment.php">
        <div class="card card-hover bg-danger text-white shadow-sm">
          💰 Verify Payments
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="view_report.php">
        <div class="card card-hover bg-info text-white shadow-sm">
          📊 View Reports
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="add_notification.php">
        <div class="card card-hover bg-secondary text-white shadow-sm">
          🔔 Add Notification
        </div>
      </a>
    </div>

    <div class="col-lg-4 col-md-6">
      <a href="manage_schedule.php">
        <div class="card card-hover bg-dark text-white shadow-sm">
          🗓️ Manage Schedule
        </div>
      </a>
    </div>
    <div class="col-lg-4 col-md-6">
      <a href="view_message.php">
        <div class="card card-hover bg-light text-dark shadow-sm">
          💌 View Messages
        </div>
      </a>
    </div>

  </div>

</div>

</body>
</html>
<?php include('../includes/footer.php'); ?>
