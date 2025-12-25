<?php
session_start();
require_once("../config/config.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){
    header("Location: ../auth/login.php");
    exit();
}

$keyword = '';
if(isset($_GET['search'])){
    $keyword = $conn->real_escape_string($_GET['search']);
    $techs = $conn->query("SELECT * FROM technicians WHERE t_name LIKE '%$keyword%' OR specialty LIKE '%$keyword%'");
}else{
    $techs = $conn->query("SELECT * FROM technicians");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Search Technician</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    min-height: 100vh;
    font-family: 'Segoe UI', sans-serif;
    padding: 40px 0;
}
.container {
    max-width: 1000px;
}
.card-search {
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.25);
    color: #fff;
}
.card-search h2 {
    color: #ffd700;
    font-weight: bold;
    text-align: center;
    margin-bottom: 30px;
}
.table {
    background: rgba(255,255,255,0.05);
    color: #fff;
}
.table th, .table td {
    vertical-align: middle;
}
.input-group .form-control {
    border-radius: 8px 0 0 8px;
}
.input-group .btn {
    border-radius: 0 8px 8px 0;
}
.btn-back {
    margin-top: 20px;
}
/* Badge for availability */
.badge-yes {
    background-color: #28a745;
    color: #fff;
}
.badge-no {
    background-color: #dc3545;
    color: #fff;
}
</style>
</head>
<body>
<div class="container">
    <div class="card-search">
        <h2>🔍 Search Technician</h2>
        <form method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Name or Specialty" value="<?= htmlspecialchars($keyword) ?>">
                <button type="submit" class="btn btn-warning">Search</button>
            </div>
        </form>

        <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Specialty</th>
                    <th>Location</th>
                    <th>Available</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $techs->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['t_id'] ?></td>
                    <td><?= $row['t_name'] ?></td>
                    <td><?= $row['phone'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['specialty'] ?></td>
                    <td><?= $row['location'] ?></td>
                    <td>
                        <?php if(strtolower($row['available'])=='yes'): ?>
                            <span class="badge badge-yes">Yes</span>
                        <?php else: ?>
                            <span class="badge badge-no">No</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>

        <a href="dashboard.php" class="btn btn-warning btn-back">⬅ Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php'); ?>