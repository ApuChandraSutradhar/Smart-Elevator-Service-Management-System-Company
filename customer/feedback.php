<?php 
include("../config/config.php"); 
session_start();
if(!isset($_SESSION['user_id']) || $_SESSION['role']!='customer'){ 
    header("Location: ../auth/login.php"); 
    exit; 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Feedback</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background: linear-gradient(135deg,#a1c4fd,#c2e9fb); font-family:'Segoe UI',sans-serif; padding:40px 0; }
.card-feedback {
    background: rgba(255,255,255,0.25);
    backdrop-filter: blur(10px);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
    max-width:500px;
    margin:0 auto;
}
h2 { text-align:center; color:#ffbf00; font-weight:bold; margin-bottom:25px; }
.btn-submit { background:#0072ff; color:#fff; font-weight:bold; border-radius:8px; }
.btn-submit:hover { background:#005bb5; }
</style>
</head>
<body>
<div class="container">
    <div class="card-feedback">
        <h2>⭐ Give Feedback</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Booking ID</label>
                <input type="number" name="r_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Rating (1-5)</label>
                <input type="number" name="rating" min="1" max="5" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Comment</label>
                <textarea name="comment" class="form-control"></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-submit w-100">Submit Feedback</button>
        </form>
    </div>
</div>

<?php
if(isset($_POST['submit'])){
    $cid = $_SESSION['user_id'];
    $rid = $_POST['r_id'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];
    $check = $conn->query("SELECT * FROM service_requests WHERE r_id='$rid' AND c_id='$cid'");
    if($check->num_rows > 0){
        $sql = "INSERT INTO feedback (c_id, r_id, rating, comment) VALUES ('$cid','$rid','$rating','$comment')";
        if($conn->query($sql)){
            echo "<script>alert('Feedback submitted successfully!'); window.location='my_bookings.php';</script>";
        } else { echo "Error: ".$conn->error; }
    } else { echo "<script>alert('Invalid Booking ID!');</script>"; }
}
?>
</body>
</html>
<?php include('../includes/footer.php'); ?>