<?php
session_start();
include("../config/config.php");
include("../config/price.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){ 
    header("Location: ../auth/login.php"); 
    exit; 
} 

$customer_id = $_SESSION['user_id'];
$msg = "";


if(isset($_POST['pay_now'])){
    $r_id = intval($_POST['r_id']);
    $amount = floatval($_POST['amount']);
    $method = $conn->real_escape_string($_POST['method']);

    if($r_id>0 && $amount>0 && !empty($method)){
    
        $check = $conn->prepare("SELECT p_id FROM payments WHERE r_id=? AND c_id=?");
        $check->bind_param("ii", $r_id, $customer_id);
        $check->execute();
        $check->store_result();

        if($check->num_rows > 0){
            
            $stmt = $conn->prepare("UPDATE payments SET amount=?, method=?, status='Pending', p_date=NOW() WHERE r_id=? AND c_id=?");
            $stmt->bind_param("dsii", $amount, $method, $r_id, $customer_id);
            $stmt->execute();
            $msg = "✅ Payment request updated successfully!";
        } else {
            
            $stmt = $conn->prepare("INSERT INTO payments (c_id, r_id, amount, status, method, p_date) VALUES (?,?,?,?,?,NOW())");
            $status = 'Pending';
            $stmt->bind_param("iidss", $customer_id, $r_id, $amount, $status, $method);
            $stmt->execute();
            $msg = "✅ Payment request submitted successfully!";

        }
    } else {
        $msg = "⚠ Please fill all fields correctly.";
    }
}


$sql = "SELECT sr.*, p.amount, p.status as payment_status, p.method, p.p_date 
        FROM service_requests sr
        LEFT JOIN (
            SELECT p1.* FROM payments p1
            INNER JOIN (
                SELECT r_id, MAX(p_id) as latest_pid FROM payments GROUP BY r_id
            ) p2 ON p1.r_id=p2.r_id AND p1.p_id=p2.latest_pid
        ) p ON sr.r_id=p.r_id
        WHERE sr.c_id=?
        ORDER BY sr.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
<title>Make Payment</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
<div class="container">
<h2 class="text-center mb-4">💰 Make Payment</h2>
<a href="dashboard.php" class="btn btn-secondary mb-3">⬅ Back</a>
<?php if(!empty($msg)): ?>
<div class="alert alert-info"><?= $msg ?></div>
<?php endif; ?>
<table class="table table-bordered">
<thead class="table-dark">
<tr>
<th>ID</th>
<th>Service</th>
<th>Status</th>
<th>Amount</th>
<th>Payment Status</th>
<th>Method</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php while($row=$result->fetch_assoc()): 
    $service_price = $service_prices[$row['r_type']] ?? 0;
    $payment_label = 'Not Paid';
    $badge_class = 'bg-danger';

    if(!empty($row['payment_status'])){
        if($row['payment_status']=='Verified'){
            $payment_label='Payment Successful';
            $badge_class='bg-success';
        } elseif($row['payment_status']=='Pending'){
            $payment_label='Pending';
            $badge_class='bg-warning text-dark';
        } elseif($row['payment_status']=='Rejected'){
            $payment_label='Rejected';
            $badge_class='bg-danger';
        }
    }
?>
<tr>
<td><?= $row['r_id'] ?></td>
<td><?= htmlspecialchars($row['r_type']) ?></td>
<td><?= $row['status'] ?></td>
<td><?= $row['amount'] ?: $service_price ?> ৳</td>
<td><span class="badge <?= $badge_class ?>"><?= $payment_label ?></span></td>
<td><?= $row['method'] ?: '-' ?></td>
<td><?= $row['p_date'] ?: '-' ?></td>
<td>
<?php if(empty($row['payment_status']) || $row['payment_status']=='Rejected'): ?>
<form method="post" class="d-flex">
<input type="hidden" name="r_id" value="<?= $row['r_id'] ?>">
<input type="number" name="amount" value="<?= $service_price ?>" class="form-control form-control-sm me-1" required>
<select name="method" class="form-select form-select-sm me-1" required>
<option value="">--Select--</option>
<option value="Cash">Cash</option>
<option value="Bkash">Bkash</option>
<option value="Nagad">Nagad</option>
</select>
<button type="submit" name="pay_now" class="btn btn-success btn-sm">Pay</button>
</form>
<?php else: ?>
✅ Done
<?php endif; ?>
</td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
</div>
</body>
</html>
<?php include('../includes/footer.php'); ?>