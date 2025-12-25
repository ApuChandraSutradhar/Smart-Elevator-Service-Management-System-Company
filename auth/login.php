<?php 
include("../config/config.php"); 
session_start(); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login - Elevator System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      height: 100vh;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      background: linear-gradient(135deg, #00c6ff, #ffe259);
      font-family: 'Segoe UI', sans-serif;
    }
    .login-box {
      width: 400px;
      background: #fff;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0px 6px 20px rgba(0,0,0,0.25);
      animation: fadeIn 1s ease-in-out;
    }
    .login-box img {
      display: block;
      margin: 0 auto 15px auto;
      max-width: 80px;
    }
    .login-box h3 {
      text-align: center;
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
    a {
      text-decoration: none;
      color: #0072ff;
      font-weight: 500;
    }
    a:hover {
      text-decoration: underline;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-20px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="login-box">
    <img src="../assets/images/logo.png" alt="System Logo">

    <h3>User Login</h3>

    <form method="POST" action="">
      <div class="mb-3">
        <label>Email Address</label>
        <input type="email" name="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control" required>
      </div>
      <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
      <p class="text-center mt-3">
        Don’t have an account? <a href="register.php">Register</a>
      </p>
    </form>
  </div>

<?php
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM admins WHERE email='$email' AND password='$password' LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['user_id'] = $row['a_id'];
        $_SESSION['role'] = 'admin';
        $_SESSION['name'] = $row['a_name'];
        header("Location: ../admin/dashboard.php");
        exit;
    }
    $sql = "SELECT * FROM technicians WHERE email='$email' AND password='$password' LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['user_id'] = $row['t_id'];
        $_SESSION['role'] = 'technician';
        $_SESSION['name'] = $row['t_name'];
        header("Location: ../technician/dashboard.php");
        exit;
    }
    $sql = "SELECT * FROM customers WHERE email='$email' AND password='$password' LIMIT 1";
    $res = $conn->query($sql);
    if ($res && $res->num_rows == 1) {
        $row = $res->fetch_assoc();
        $_SESSION['user_id'] = $row['c_id'];
        $_SESSION['role'] = 'customer';
        $_SESSION['name'] = $row['c_name'];
        header("Location: ../customer/dashboard.php");
        exit;
    }

    echo "<script>alert('Invalid Email or Password');</script>";
}
?>
</body>
</html>
