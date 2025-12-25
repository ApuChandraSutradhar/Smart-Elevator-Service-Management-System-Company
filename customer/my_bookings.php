<?php
include("../config/config.php"); 
session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){ 
    header("Location: ../auth/login.php"); 
    exit; 
} 

$customer_id = $_SESSION['user_id'];

// Fetch bookings + latest payment status
$sql = "SELECT sr.*, p.status as payment_status, p.amount, p.method, p.p_date
        FROM service_requests sr
        LEFT JOIN (
            SELECT p1.* FROM payments p1
            INNER JOIN (
                SELECT r_id, MAX(p_id) as latest_pid FROM payments GROUP BY r_id
            ) p2 ON p1.r_id = p2.r_id AND p1.p_id = p2.latest_pid
        ) p ON sr.r_id = p.r_id
        WHERE sr.c_id=?
        ORDER BY sr.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>My Bookings</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background:#f0f4f7; font-family:'Segoe UI',sans-serif; padding:40px 0; }
.table-container { background: rgba(255,255,255,0.3); backdrop-filter: blur(10px); border-radius: 20px; padding: 25px; box-shadow: 0 6px 20px rgba(0,0,0,0.15); }
h2 { text-align:center; color:#ffbf00; font-weight:bold; margin-bottom:20px; }
.table th { background:#0072ff; color:#fff; }
.table td { background: rgba(255,255,255,0.6); }
</style>
</head>
<body>
<div class="container table-container">
<h2>📖 My Service Bookings</h2>
<a href="dashboard.php" class="btn btn-secondary btn-sm mb-3">⬅ Back</a>
<table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Description</th>
        <th>Location</th>
        <th>Status</th>
        <th>Payment</th>
        <th>Amount</th>
        <th>Method</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
<?php
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $payment_label = "Not Paid";
        $badge_class = "bg-danger";

        if(!empty($row['payment_status'])){
            if($row['payment_status'] == 'Verified'){
                $payment_label = "Payment Successful";
                $badge_class = "bg-success";
            } elseif($row['payment_status'] == 'Pending'){
                $payment_label = "Pending";
                $badge_class = "bg-warning text-dark";
            } elseif($row['payment_status'] == 'Rejected'){
                $payment_label = "Rejected";
                $badge_class = "bg-danger";
            }
        }

        echo "<tr>
                <td>{$row['r_id']}</td>
                <td>{$row['r_type']}</td>
                <td>{$row['description']}</td>
                <td>{$row['location']}</td>
                <td>{$row['status']}</td>
                <td><span class='badge {$badge_class}'>{$payment_label}</span></td>
                <td>".($row['amount'] ?? '-')."</td>
                <td>".($row['method'] ?? '-')."</td>
                <td>".($row['p_date'] ?? '-')."</td>
              </tr>";
    }
} else { 
    echo "<tr><td colspan='9' class='text-center'>No bookings found.</td></tr>"; 
}
?>
    </tbody>
</table>
</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>