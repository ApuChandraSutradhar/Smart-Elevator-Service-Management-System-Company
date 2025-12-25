<?php include("../config/config.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Register - Elevator System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('../assets/images/bg.jpg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }
    .register-box {
      max-width: 450px;
      margin: 60px auto;
      background: rgba(255, 255, 255, 0.25);
      padding: 30px;
      border-radius: 15px;
      border: 2px solid rgba(255,255,255,0.4);
      backdrop-filter: blur(10px);
      -webkit-backdrop-filter: blur(10px);
      box-shadow: 0px 6px 20px rgba(0,0,0,0.3);
      text-align: center;
    }
    .register-box img.logo {
      width: 80px;
      margin-bottom: 10px;
    }
    .register-box h3 {
      font-size: 30px;
      font-weight: 900;
      margin-bottom: 20px;
      background: linear-gradient(45deg, #ffeb3b, #03a9f4);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      letter-spacing: 1px;
    }
    label {
  font-weight: normal;
  color: #000000;
  }

    .form-control {
      font-weight: 600;
    }
    .btn-custom {
      background: linear-gradient(90deg, #2196f3, #4caf50);
      border: none;
      color: #fff;
      font-weight: bold;
      transition: 0.3s;
    }
    .btn-custom:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }
    p, a {
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="register-box">
      <img src="../assets/images/logo.png" alt="Logo" class="logo">

      <h3>Create User Account</h3>

      <form method="POST" action="">
        <div class="mb-3"><label>Full Name</label><input type="text" name="name" class="form-control" required></div>
        <div class="mb-3"><label>Email Address</label><input type="email" name="email" class="form-control" required></div>
        <div class="mb-3"><label>Password</label><input type="password" name="password" class="form-control" required></div>
        <div class="mb-3"><label>Phone Number</label><input type="text" name="phone" class="form-control" required></div>
        <button type="submit" name="register" class="btn btn-custom w-100">Register</button>
        <p class="text-center mt-3 text-white">Already have an account? <a href="login.php" class="text-warning">Login</a></p>
      </form>
    </div>
  </div>

<?php
if (isset($_POST['register'])) {
    $name  = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = md5($_POST['password']); 

    $chk = $conn->query("SELECT * FROM customers WHERE email='$email'");
    if ($chk->num_rows > 0) {
        echo "<script>alert('Email already registered. Please login.'); window.location='login.php';</script>";
        exit;
    }

    $sql = "INSERT INTO customers (c_name, email, phone, password) VALUES ('$name','$email','$phone','$password')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registration Successful! Please Login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
</body>
</html>
<?php include('../includes/footer.php'); ?>