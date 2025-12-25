<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "elevator_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$success = $error = "";
if (isset($_POST['submit'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $message = $conn->real_escape_string($_POST['message']);

    $sql = "INSERT INTO contact_messages (name,email,message,created_at) 
            VALUES ('$name','$email','$message',NOW())";

    if ($conn->query($sql)) {
        $success = "Message sent successfully!";
    } else {
        $error = "Error: " . $conn->error;
    }
}

$sql_messages = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result_messages = $conn->query($sql_messages);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Messages</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body {
    background: #f0f4f8;
    font-family: Arial, sans-serif;
    min-height: 100vh;
    margin: 0;
    padding: 0;
}
.container {
    padding-top: 90px;
}
.card {
    border-radius: 15px;
    padding: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}
.table thead th {
    background: #0072ff;
    color: #fff;
}
.alert { border-radius: 10px; }
</style>
</head>
<body>

<?php include('includes/header.php'); ?>

<div class="container">
    <h2 class="mb-4 text-center">Contact Messages</h2>

    <div class="card">
        <?php if ($success) echo '<div class="alert alert-success">'.$success.'</div>'; ?>
        <?php if ($error) echo '<div class="alert alert-danger">'.$error.'</div>'; ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label>Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Message</label>
                <textarea name="message" rows="4" class="form-control" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary w-100">Send Message</button>
        </form>
    </div>
</div>

</body>
</html>
<?php include('includes/footer.php'); ?>