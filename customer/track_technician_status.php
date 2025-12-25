<?php
session_start();
require_once("../config/config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){
    header("Location: ../auth/login.php");
    exit();
}

$customer_id = $_SESSION['user_id'];

$requests = $conn->query("
    SELECT sr.r_id, sr.r_type, sr.status, sr.description, sr.location, t.t_name, t.phone
    FROM service_requests sr
    LEFT JOIN technicians t ON sr.t_id = t.t_id
    WHERE sr.c_id = $customer_id
    ORDER BY sr.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Track Technician Status</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
}
.container {
    padding-top: 50px;
}
.glass-card {
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.15);
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 8px 32px rgba(0,0,0,0.2);
    color: #fff;
}
.glass-card h2 {
    font-weight: bold;
    color: #ffd700;
    text-align: center;
    margin-bottom: 20px;
}
table th, table td {
    color: #fff;
}
.logo {
    display: block;
    margin: 0 auto 15px;
    width: 80px;
}
</style>
</head>
<body>
<div class="container">
    <div class="glass-card">
        <img src="../assets/images/logo.png" class="logo" alt="Logo">
        <h2>Track Technician Status</h2>
        <table class="table table-borderless table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service</th>
                    <th>Status</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Technician</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $requests->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['r_id'] ?></td>
                    <td><?= $row['r_type'] ?></td>
                    <td><?= $row['status'] ?></td>
                    <td><?= $row['description'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td><?= $row['t_name'] ?? '-' ?></td>
                    <td><?= $row['phone'] ?? '-' ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn btn-warning mt-3 w-100">⬅ Back</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php'); ?>