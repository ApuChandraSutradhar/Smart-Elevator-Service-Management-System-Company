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
<title>Book Service</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
    font-family: 'Segoe UI', sans-serif;
    padding: 40px 0;
}
.card-form {
    backdrop-filter: blur(10px);
    background: rgba(255,255,255,0.25);
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}
.card-form h2 {
    text-align: center;
    color: #ffbf00;
    margin-bottom: 25px;
    font-weight: bold;
}
.btn-submit {
    background: #0072ff;
    color: #fff;
    font-weight: bold;
    border-radius: 8px;
}
.btn-submit:hover { background: #005bb5; }
</style>
</head>
<body>
<div class="container">
    <div class="card-form mx-auto" style="max-width:500px;">
        <h2>📌 Book a New Service</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Service Type</label>
                <select name="type" class="form-control" required>
                    <option value="Installation">Installation</option>
                    <option value="Repair">Repair</option>
                    <option value="Maintenance">Maintenance</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Location</label>
                <input type="text" name="location" class="form-control" required>
            </div>
            <button type="submit" name="book" class="btn btn-submit w-100">Submit</button>
        </form>
    </div>
</div>

<?php
if(isset($_POST['book'])){
    $cid = $_SESSION['user_id'];
    $type = $_POST['type'];
    $desc = $_POST['description'];
    $loc = $_POST['location'];
    $sql = "INSERT INTO service_requests (c_id, r_type, description, location) VALUES ('$cid','$type','$desc','$loc')";
    if($conn->query($sql)){
        echo "<script>alert('Service Booked Successfully!'); window.location='my_bookings.php';</script>";
    } else { echo "Error: ".$conn->error; }
}
?>
</body>
</html>
<?php include('../includes/footer.php'); ?>
