<?php
session_start();
if(!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}
require_once("../config/config.php");

// Delete user
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM customers WHERE c_id = $id");
    header("Location: manage_users.php");
    exit();
}

// Fetch all customers
$result = $conn->query("SELECT * FROM customers");
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Manage Users</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
<h2 class="mb-4">👤 Manage Users</h2>
<table class="table table-striped table-bordered">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Action</th></tr>
<?php while($row=$result->fetch_assoc()): ?>
<tr>
<td><?= $row['c_id'] ?></td>
<td><?= $row['c_name'] ?></td>
<td><?= $row['email'] ?></td>
<td><?= $row['phone'] ?></td>
<td>
<a href="?delete=<?= $row['c_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
</td>
</tr>
<?php endwhile; ?>
</table>
<a href="dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>