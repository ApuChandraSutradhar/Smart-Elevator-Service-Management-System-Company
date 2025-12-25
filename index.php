<?php include('includes/header.php'); ?>

<section style="position: relative; width: 100%; height: 100vh; background: url('assets/images/elevator-bg.jpg') no-repeat center center/cover; display: flex; flex-direction: column; justify-content: center; align-items: center; color: #fff; text-align: center;">

    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5); z-index:1;"></div>
    
    <div style="position: relative; z-index:2;">
        <img src="assets/images/logo.png" alt="Elevator System Logo" style="width: 120px; margin-bottom: 20px;">
        <h1 style="font-size: 3rem; font-weight: bold; margin-bottom: 15px;">Welcome to Smart Elevator Service & Management System</h1>
        <p style="font-size: 1.2rem; max-width: 700px; margin: 0 auto 40px;">
            Request services, track status, and manage your elevator maintenance efficiently.
        </p>
        <div style="display:flex; flex-wrap:wrap; justify-content:center; gap:20px;">
            <a href="customer/dashboard.php" class="dashboard-btn" style="background:#0072ff;">Customer Dashboard</a>
            <a href="admin/dashboard.php" class="dashboard-btn" style="background:#28a745;">Admin Dashboard</a>
            <a href="technician/dashboard.php" class="dashboard-btn" style="background:#ffc107; color:#000;">Technician Dashboard</a>
        </div>
    </div>
</section>

<style>
.dashboard-btn {
    padding: 18px 35px;
    color: #fff;
    text-decoration: none;
    border-radius: 10px;
    font-size: 1.1rem;
    font-weight: bold;
    box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    transition: 0.3s;
}
.dashboard-btn:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.5);
}
</style>
<?php include('includes/footer.php'); ?>