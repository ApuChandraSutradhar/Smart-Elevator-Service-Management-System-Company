<?php
session_start();
require_once("../config/config.php");

// If technician already logged in
if(isset($_SESSION['t_id'])){
    header("Location: ../technician/dashboard.php");
    exit();
}

$error = "";

if(isset($_POST['login'])){
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $query = $conn->query("SELECT * FROM technicians WHERE email='$email' AND password='$password' LIMIT 1");
    if($query->num_rows > 0){
        $tech = $query->fetch_assoc();
        $_SESSION['t_id'] = $tech['t_id'];
        $_SESSION['t_name'] = $tech['t_name'];
        header("Location: ../technician/dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Technician Login</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background: linear-gradient(135deg, #00c6ff, #0072ff); /* আকাশী + নীল গ্রেডিয়েন্ট */
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Segoe UI', sans-serif;
    }
    .login-card {
        width: 380px;
        border-radius: 15px;
        background: #ffffff;
        padding: 30px;
        box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
        animation: fadeIn 1s ease-in-out;
        text-align: center;
    }
    .login-card img {
        width: 80px;
        margin-bottom: 15px;
    }
    .login-card h3 {
        margin-bottom: 20px;
        font-weight: bold;
        color: #0072ff;
    }
    .btn-custom {
        background: #00c6ff;
        color: #fff;
        font-weight: bold;
        border-radius: 8px;
        transition: 0.3s;
    }
    .btn-custom:hover {
        background: #0072ff;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
</head>
<body>

<div class="login-card">
    <img src="../assets/images/logo.png" alt="Logo">

    <h3>Technician Login</h3>

    <?php if($error): ?>
    <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
        <a href="../auth/logout.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
