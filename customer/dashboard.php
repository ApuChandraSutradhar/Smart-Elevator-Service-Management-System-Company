<?php
session_start();
include('../config/config.php');

// Session Check
if(!isset($_SESSION['user_id']) || $_SESSION['role']!='customer'){
    header("Location: ../auth/login.php");
    exit;
}

// Include header
include('../includes/header.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Dashboard</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: linear-gradient(135deg, #00c6ff, #0072ff);
    font-family: 'Segoe UI', sans-serif;
    min-height: 100vh;
    padding-top: 50px;
}
.dashboard-container {
    max-width: 1000px;
    margin: 0 auto;
}
.glass-card {
    backdrop-filter: blur(12px);
    background: rgba(255,255,255,0.15);
    border-radius: 20px;
    padding: 40px 30px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    color: #fff;
}
.glass-card h2 {
    font-weight: bold;
    color: #ffd700;
    text-align: center;
    margin-bottom: 30px;
}
.card-link {
    background: rgba(255,255,255,0.1);
    border-radius: 15px;
    padding: 20px;
    text-align: center;
    color: #fff;
    font-weight: bold;
    transition: 0.3s;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 120px;
}
.card-link:hover {
    background: rgba(255,255,255,0.25);
    text-decoration: none;
    transform: translateY(-5px);
}
.card-link i {
    font-size: 30px;
    margin-bottom: 10px;
}
.logo {
    display: block;
    margin: 0 auto 20px;
    width: 80px;
}
.logout-btn {
    position: absolute;
    top: 20px;
    right: 20px;
}
</style>
<!-- Font Awesome for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<a href="../auth/logout.php" class="btn btn-danger btn-sm logout-btn">Logout</a>
<div class="dashboard-container">
    <div class="glass-card">
        <img src="../assets/images/logo.png" class="logo" alt="Logo">
        <h2>Welcome, <?= $_SESSION['name']; ?> 👋</h2>
        <div class="row g-3 mt-4">
            <!-- Old Features -->
            <div class="col-md-6 col-lg-4">
                <a href="book_service.php" class="card-link">
                    <i class="fas fa-calendar-plus"></i>
                    Book a Service
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="my_bookings.php" class="card-link">
                    <i class="fas fa-book"></i>
                    My Bookings
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="feedback.php" class="card-link">
                    <i class="fas fa-star"></i>
                    Give Feedback
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="make_payment.php" class="card-link">
                    <i class="fas fa-credit-card"></i>
                    Make Payment
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="search_technician.php" class="card-link">
                    <i class="fas fa-search"></i>
                    Search Technician
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="track_technician_status.php" class="card-link">
                    <i class="fas fa-tools"></i>
                    Track Technician Status
                </a>
            </div>
            <div class="col-md-6 col-lg-4">
                <a href="notifications.php" class="card-link">
                    <i class="fas fa-bell"></i>
                    Receive Notifications
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php include('../includes/footer.php'); ?>
