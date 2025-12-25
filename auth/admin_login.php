<?php
session_start();
require '../config/config.php'; // Database connection

if(isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admins WHERE a_name='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $admin = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin['a_id'];
        $_SESSION['admin_name'] = $admin['a_name'];
        header("Location: ../admin/dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            width: 400px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0,0,0,0.2);
            background: #fff;
            padding: 30px;
            position: relative;
        }
        .login-card h2 {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #4e73df;
        }
        .logo {
            display: block;
            margin: 0 auto 15px auto;
            max-width: 100px;
        }
        .btn-custom {
            background: #4e73df;
            color: #fff;
            font-weight: bold;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background: #2e59d9;
        }
        .error-text {
            color: red;
            text-align: center;
            margin-bottom: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="login-card">
    <!-- Logo -->
    <img src="../assets/images/logo.png" alt="Logo" class="logo">

    <h2>Admin Login</h2>
    <?php if(isset($error)) { echo "<p class='error-text'>$error</p>"; } ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <button type="submit" name="login" class="btn btn-custom w-100">Login</button>
    </form>
    <p class="text-center mt-3">
        <a href="login.php">Customer Login</a>
    </p>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
